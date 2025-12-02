<?php

/**
 * API Endpoint untuk mencari buku dari berbagai sumber
 * 
 * Usage: api/search_books_api.php?query=programming&source=google&maxResults=20
 * 
 * Parameters:
 * - query: Kata kunci pencarian (required)
 * - source: Sumber API (google, openlibrary) default: google
 * - maxResults: Jumlah maksimal hasil (default: 20)
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$query = $_GET['query'] ?? '';
$source = $_GET['source'] ?? 'google';
$maxResults = (int)($_GET['maxResults'] ?? 20);

if (empty($query)) {
    echo json_encode([
        'success' => false,
        'message' => 'Parameter query diperlukan'
    ]);
    exit;
}

try {
    switch ($source) {
        case 'google':
            $result = searchGoogleBooks($query, $maxResults);
            break;
        case 'openlibrary':
            $result = searchOpenLibrary($query, $maxResults);
            break;
        default:
            $result = [
                'success' => false,
                'message' => 'Sumber API tidak valid. Pilih: google atau openlibrary'
            ];
    }

    echo json_encode($result, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

/**
 * Search books from Google Books API
 */
function searchGoogleBooks($query, $maxResults)
{
    $apiUrl = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($query) .
        '&maxResults=' . $maxResults . '&printType=books';

    $response = file_get_contents($apiUrl);
    if ($response === false) {
        return ['success' => false, 'message' => 'Gagal mengakses Google Books API'];
    }

    $data = json_decode($response, true);

    if (!isset($data['items'])) {
        return ['success' => true, 'count' => 0, 'books' => []];
    }

    $books = [];
    foreach ($data['items'] as $item) {
        $volumeInfo = $item['volumeInfo'];

        $books[] = [
            'title' => $volumeInfo['title'] ?? 'No Title',
            'authors' => $volumeInfo['authors'] ?? ['Unknown Author'],
            'publisher' => $volumeInfo['publisher'] ?? 'Unknown',
            'publishedDate' => $volumeInfo['publishedDate'] ?? 'N/A',
            'description' => $volumeInfo['description'] ?? '',
            'isbn' => getISBN($volumeInfo['industryIdentifiers'] ?? []),
            'pageCount' => $volumeInfo['pageCount'] ?? 0,
            'categories' => $volumeInfo['categories'] ?? [],
            'thumbnail' => $volumeInfo['imageLinks']['thumbnail'] ?? '',
            'previewLink' => $volumeInfo['previewLink'] ?? '',
            'language' => $volumeInfo['language'] ?? 'en'
        ];
    }

    return [
        'success' => true,
        'source' => 'Google Books',
        'count' => count($books),
        'books' => $books
    ];
}

/**
 * Search books from Open Library API
 */
function searchOpenLibrary($query, $maxResults)
{
    $apiUrl = 'https://openlibrary.org/search.json?q=' . urlencode($query) . '&limit=' . $maxResults;

    $response = file_get_contents($apiUrl);
    if ($response === false) {
        return ['success' => false, 'message' => 'Gagal mengakses Open Library API'];
    }

    $data = json_decode($response, true);

    if (!isset($data['docs']) || count($data['docs']) === 0) {
        return ['success' => true, 'count' => 0, 'books' => []];
    }

    $books = [];
    foreach ($data['docs'] as $doc) {
        $books[] = [
            'title' => $doc['title'] ?? 'No Title',
            'authors' => $doc['author_name'] ?? ['Unknown Author'],
            'publisher' => isset($doc['publisher']) ? $doc['publisher'][0] : 'Unknown',
            'publishedDate' => $doc['first_publish_year'] ?? 'N/A',
            'isbn' => isset($doc['isbn']) ? $doc['isbn'][0] : '',
            'pageCount' => $doc['number_of_pages_median'] ?? 0,
            'categories' => $doc['subject'] ?? [],
            'thumbnail' => isset($doc['cover_i']) ? 'https://covers.openlibrary.org/b/id/' . $doc['cover_i'] . '-M.jpg' : '',
            'language' => $doc['language'] ?? []
        ];
    }

    return [
        'success' => true,
        'source' => 'Open Library',
        'count' => count($books),
        'books' => $books
    ];
}

/**
 * Get ISBN from industry identifiers
 */
function getISBN($identifiers)
{
    if (empty($identifiers)) return '';

    foreach ($identifiers as $id) {
        if ($id['type'] === 'ISBN_13') {
            return $id['identifier'];
        }
    }

    return $identifiers[0]['identifier'] ?? '';
}
