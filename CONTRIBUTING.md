# Contributing to ApGuns Store

First off, thank you for considering contributing to ApGuns Store! It's people like you that make this project better.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues to avoid duplicates. When creating a bug report, include:

- **Clear descriptive title**
- **Detailed steps to reproduce**
- **Expected behavior**
- **Actual behavior**
- **Screenshots** (if applicable)
- **Your environment** (OS, PHP version, MySQL version, browser)

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, include:

- **Clear descriptive title**
- **Detailed description** of the suggested enhancement
- **Why this enhancement would be useful**
- **Possible implementation** (if you have ideas)

### Pull Requests

1. Fork the repo and create your branch from `main`
2. If you've added code that should be tested, add tests
3. Ensure your code follows the existing style
4. Make sure your code lints
5. Issue that pull request!

## Development Setup

```bash
# Clone your fork
git clone https://github.com/YOUR_USERNAME/ApGuns-Store.git
cd ApGuns-Store

# Create a new branch
git checkout -b feature/your-feature-name

# Make your changes and commit
git add .
git commit -m "Description of your changes"

# Push to your fork
git push origin feature/your-feature-name
```

## Code Style Guidelines

- Use meaningful variable and function names
- Add comments for complex logic
- Follow PHP PSR standards where applicable
- Keep functions focused and small
- Use proper indentation (4 spaces)

## Database Changes

If your contribution involves database changes:

1. Update `database.sql` with the new schema
2. Update `install.php` if needed
3. Document the changes in your PR

## Commit Messages

- Use present tense ("Add feature" not "Added feature")
- Use imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit first line to 72 characters or less
- Reference issues and pull requests after the first line

Examples:

```
Add user authentication feature

- Implement login system
- Add session management
- Create password hashing

Closes #123
```

## Questions?

Feel free to open an issue with your question or reach out to the maintainers.

Thank you! ❤️
