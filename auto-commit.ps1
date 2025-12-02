# Auto Commit Script - Munif Store
# Script ini akan commit semua perubahan satu per satu dengan keterangan yang jelas

Write-Host "🚀 Auto Commit - Munif Store" -ForegroundColor Cyan
Write-Host "================================`n" -ForegroundColor Cyan

# Pastikan kita di directory yang benar
Set-Location $PSScriptRoot

# Cek apakah git sudah init
if (-not (Test-Path ".git")) {
    Write-Host "📦 Initializing Git repository..." -ForegroundColor Yellow
    git init
    Write-Host "✅ Git repository initialized`n" -ForegroundColor Green
}

# Configure git if not configured
$userName = git config user.name
if ([string]::IsNullOrWhiteSpace($userName)) {
    Write-Host "⚙️  Configuring Git..." -ForegroundColor Yellow
    git config user.name "Munif Store Developer"
    git config user.email "dev@munifstore.com"
    Write-Host "✅ Git configured`n" -ForegroundColor Green
}

# Daftar file dengan kategori dan commit message
$commitGroups = @(
    @{
        Name = "Database & Configuration"
        Files = @(
            @{ Path = "database.sql"; Message = "Update database schema: Enlarge columns for API import (ISBN, author, publisher, title)" }
            @{ Path = "config/db.php"; Message = "Update database configuration: Change DB name from guns_bookstore to munif_store" }
            @{ Path = "config/functions.php"; Message = "Add helper functions for application" }
        )
    },
    @{
        Name = "Rebranding - Templates & Layout"
        Files = @(
            @{ Path = "includes/header.php"; Message = "Rebranding: Update header from Guns Bookstore to Munif Store" }
            @{ Path = "includes/navbar.php"; Message = "Rebranding: Update navigation bar branding and paths" }
            @{ Path = "includes/footer.php"; Message = "Rebranding: Update footer branding and contact information" }
            @{ Path = "index.php"; Message = "Update homepage: Rebranding, add category cards with gradient design, and API badge" }
        )
    },
    @{
        Name = "Styling & Assets"
        Files = @(
            @{ Path = "assets/css/style.css"; Message = "Update CSS: Add book-actions flexbox, category-card gradient design, responsive improvements" }
            @{ Path = "assets/js/main.js"; Message = "Update JavaScript: Fix API endpoint paths for cart functionality" }
        )
    },
    @{
        Name = "Customer Pages"
        Files = @(
            @{ Path = "pages/books.php"; Message = "Update books catalog: Rebranding, improve book card layout with flexbox actions" }
            @{ Path = "pages/book_detail.php"; Message = "Update book detail page: Rebranding and UI improvements" }
            @{ Path = "pages/cart.php"; Message = "Update shopping cart: Rebranding and functionality improvements" }
            @{ Path = "pages/checkout.php"; Message = "Update checkout page: Rebranding and process improvements" }
            @{ Path = "pages/orders.php"; Message = "Update orders history: Rebranding" }
            @{ Path = "pages/order_detail.php"; Message = "Update order detail: Rebranding" }
            @{ Path = "pages/profile.php"; Message = "Update user profile: Rebranding" }
            @{ Path = "pages/login.php"; Message = "Update login page: Rebranding" }
            @{ Path = "pages/register.php"; Message = "Update register page: Rebranding" }
            @{ Path = "pages/logout.php"; Message = "Update logout functionality" }
            @{ Path = "pages/add_to_cart.php"; Message = "Update add to cart API endpoint" }
            @{ Path = "pages/update_cart.php"; Message = "Update cart update API endpoint" }
            @{ Path = "pages/remove_from_cart.php"; Message = "Update remove from cart API endpoint" }
            @{ Path = "pages/get_cart_count.php"; Message = "Update cart count API endpoint" }
        )
    },
    @{
        Name = "Admin Panel - Core"
        Files = @(
            @{ Path = "admin/dashboard.php"; Message = "Update admin dashboard: Rebranding, add Import API button with NEW badge" }
            @{ Path = "admin/manage_books.php"; Message = "Update manage books: Rebranding, integrate API import modal with validation" }
            @{ Path = "admin/add_book.php"; Message = "Update add book: Rebranding" }
            @{ Path = "admin/manage_categories.php"; Message = "Update manage categories: Rebranding" }
            @{ Path = "admin/manage_orders.php"; Message = "Update manage orders: Rebranding" }
            @{ Path = "admin/manage_users.php"; Message = "Update manage users: Rebranding" }
        )
    },
    @{
        Name = "API Import Feature"
        Files = @(
            @{ Path = "admin/import_books.php"; Message = "Add new feature: Standalone API import page for books" }
            @{ Path = "admin/process_import_books.php"; Message = "Add import processor: Handle book import with validation, truncation, and year range check" }
            @{ Path = "api/search_books_api.php"; Message = "Add API endpoint: Search books from Google Books and Open Library APIs" }
        )
    },
    @{
        Name = "Documentation"
        Files = @(
            @{ Path = "README.md"; Message = "Update README: Complete documentation with API import feature" }
            @{ Path = "API_IMPORT_GUIDE.md"; Message = "Add documentation: Comprehensive API import guide" }
            @{ Path = "INTEGRASI_COMPLETE.md"; Message = "Add documentation: API integration completion guide" }
        )
    },
    @{
        Name = "Troubleshooting Tools"
        Files = @(
            @{ Path = "install.php"; Message = "Update installer: Automatic database setup tool" }
            @{ Path = "FIX_DATABASE_NOW.php"; Message = "Add troubleshooting tool: Auto-fix database structure for import" }
            @{ Path = "fix_database_structure.php"; Message = "Add troubleshooting tool: Alternative database structure fix" }
            @{ Path = "check_database.php"; Message = "Add troubleshooting tool: Database structure checker" }
            @{ Path = "fix_isbn_column.sql"; Message = "Add SQL fix: Manual database column enlargement script" }
            @{ Path = "reset_admin_password.php"; Message = "Add troubleshooting tool: Admin password reset utility" }
            @{ Path = "SOLUSI_LOGIN.md"; Message = "Add documentation: Login troubleshooting guide" }
            @{ Path = "SOLUSI_ERROR_IMPORT.md"; Message = "Add documentation: Import error solutions" }
            @{ Path = "CARA_FIX_DATABASE.md"; Message = "Add documentation: Quick database fix guide" }
        )
    },
    @{
        Name = "Assets & Resources"
        Files = @(
            @{ Path = "assets/images/books/default.jpg.html"; Message = "Add default book cover placeholder" }
            @{ Path = "demo_api.html"; Message = "Add API testing interface for developers" }
        )
    }
)

# Add .gitignore
$gitignoreContent = @"
# Dependencies
node_modules/
vendor/

# IDE
.vscode/
.idea/
*.sublime-*

# OS Files
.DS_Store
Thumbs.db
desktop.ini

# Temporary Files
*.tmp
*.temp
*.log

# Uploaded Images (kecuali default)
assets/images/books/*
!assets/images/books/default.jpg
!assets/images/books/default.jpg.html

# Troubleshooting Tools (jangan di-commit ke production)
FIX_DATABASE_NOW.php
fix_database_structure.php
check_database.php
reset_admin_password.php
fix_isbn_column.sql

# Database dumps
*.sql.backup
dump.sql

# Environment files
.env
.env.local
"@

Write-Host "📝 Creating .gitignore..." -ForegroundColor Yellow
Set-Content -Path ".gitignore" -Value $gitignoreContent
git add .gitignore
git commit -m "Add .gitignore: Exclude temporary files and troubleshooting tools" -q
Write-Host "✅ .gitignore committed`n" -ForegroundColor Green

# Commit setiap group
$totalCommits = 0
foreach ($group in $commitGroups) {
    Write-Host "📦 Category: $($group.Name)" -ForegroundColor Cyan
    Write-Host ("─" * 50) -ForegroundColor DarkGray
    
    foreach ($item in $group.Files) {
        if (Test-Path $item.Path) {
            Write-Host "  📄 $($item.Path)" -ForegroundColor White
            git add $item.Path
            
            $commitResult = git commit -m $item.Message 2>&1
            if ($LASTEXITCODE -eq 0) {
                Write-Host "     ✅ Committed: $($item.Message)" -ForegroundColor Green
                $totalCommits++
            } else {
                Write-Host "     ⚠️  No changes or already committed" -ForegroundColor Yellow
            }
        } else {
            Write-Host "  ⚠️  File not found: $($item.Path)" -ForegroundColor Yellow
        }
    }
    Write-Host ""
}

# Commit any remaining files
Write-Host "📦 Checking for remaining files..." -ForegroundColor Cyan
$status = git status --porcelain
if ($status) {
    Write-Host "  📄 Found uncommitted files, adding them..." -ForegroundColor White
    git add .
    git commit -m "Add remaining files and updates" -q
    if ($LASTEXITCODE -eq 0) {
        Write-Host "  ✅ Committed remaining files" -ForegroundColor Green
        $totalCommits++
    }
} else {
    Write-Host "  ✅ No remaining files to commit" -ForegroundColor Green
}

Write-Host "`n" + ("=" * 50) -ForegroundColor Cyan
Write-Host "🎉 Auto Commit Complete!" -ForegroundColor Green
Write-Host "📊 Total commits: $totalCommits" -ForegroundColor Cyan
Write-Host ("=" * 50) -ForegroundColor Cyan

# Show git log summary
Write-Host "`n📜 Recent Commits:" -ForegroundColor Cyan
git log --oneline --graph --decorate -10

Write-Host "`n💡 Tips:" -ForegroundColor Yellow
Write-Host "  - Use 'git log' to see full commit history" -ForegroundColor White
Write-Host "  - Use 'git status' to check repository status" -ForegroundColor White
Write-Host "  - Use 'git remote add origin <url>' to add remote repository" -ForegroundColor White
Write-Host "  - Use 'git push -u origin main' to push to remote" -ForegroundColor White

Write-Host "`n✨ Done! All changes have been committed with clear messages.`n" -ForegroundColor Green
