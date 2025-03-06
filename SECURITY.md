# Security Practices

This document outlines the security practices implemented in this project to ensure code quality and prevent security vulnerabilities.

## Security Tools

### Static Application Security Testing (SAST)

We use the following tools for static analysis:

1. **PHPStan** - For static code analysis to detect potential bugs and security issues
2. **PHP_CodeSniffer** - For enforcing coding standards and security best practices

### Software Composition Analysis (SCA)

We use the following tools to scan dependencies:

1. **Security Checker** - For checking Composer dependencies against known vulnerabilities
2. **Snyk** - For deeper analysis of dependencies in our CI/CD pipeline

## Security Automation

### Pre-commit Hooks

We use Husky to run security checks before each commit:

- PHPStan analysis on staged PHP files
- PHP_CodeSniffer checks on staged PHP files
- Security Checker for dependency vulnerabilities

> **Note**: Our setup is compatible with Husky v9+ and follows the latest format requirements.

### GitHub Actions

We have a GitHub workflow (`security-scan.yml`) that runs security checks on:
- Push to main/master branches
- Pull requests to main/master branches
- Weekly scheduled scans

## Setting Up Security Tools

### Local Development Setup

1. Install dependencies:
   ```bash
   composer install
   npm install
   ```

2. Set up security hooks:
   ```bash
   npm run setup-security
   ```

### Running Security Checks Manually

```bash
# Run all security checks
composer security:check

# Run individual checks
composer security:sast     # Static analysis with PHPStan
composer security:phpcs    # Code style and security checks
composer security:deps     # Dependency vulnerability checks
```

### Bypassing Pre-commit Hooks

In rare cases when you need to bypass the pre-commit hooks:

```bash
git commit --no-verify -m "Your commit message"
```

## Security Policies

1. All code must pass security checks before being merged
2. Dependencies with high or critical vulnerabilities must be addressed promptly
3. Security issues should be reported according to our vulnerability disclosure policy

## Vulnerability Disclosure

If you discover a security vulnerability, please send an email to [security@example.com](mailto:security@example.com). All security vulnerabilities will be promptly addressed. 