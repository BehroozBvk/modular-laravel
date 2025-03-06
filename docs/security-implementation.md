# Security Implementation Guide

This document provides a detailed explanation of the security measures implemented in our Laravel project, focusing on Static Application Security Testing (SAST) and Software Composition Analysis (SCA).

## Overview

Our security implementation follows industry best practices and integrates security checks at multiple levels:

1. **Local Development** - Pre-commit hooks to catch issues before they enter the codebase
2. **Continuous Integration** - GitHub Actions workflow for automated security scanning
3. **Manual Verification** - Commands for developers to run security checks on demand

## Implementation Details

### 1. Static Application Security Testing (SAST)

#### PHPStan Configuration

We use PHPStan at level 5 (out of 9) to balance thoroughness with practicality. Our configuration in `phpstan.neon` includes:

```yaml
parameters:
    level: 5
    paths:
        - Modules
    excludePaths:
        - vendor
        - node_modules
        - storage
    checkMissingIterableValueType: false
    checkGenericClassInNonGenericObjectType: false
```

This configuration:
- Focuses analysis on our custom code in the `Modules` directory
- Excludes vendor dependencies and storage directories
- Disables some overly strict checks that might generate too many false positives

#### PHP_CodeSniffer

We use PHP_CodeSniffer with PSR-12 and Security standards to enforce coding style and security best practices.

### 2. Software Composition Analysis (SCA)

We use the Security Checker tool to scan our Composer dependencies for known vulnerabilities. This helps us identify and address security issues in third-party packages.

### 3. Automation Setup

#### Pre-commit Hooks

Our pre-commit hooks:
1. Identify staged PHP files
2. Run PHPStan on those files
3. Run PHP_CodeSniffer on those files
4. Check dependencies for vulnerabilities

This ensures that security issues are caught before code is committed.

> **Note**: Our pre-commit hook is compatible with Husky v9+ and follows the latest format requirements.

#### GitHub Actions Workflow

Our GitHub workflow (`security-scan.yml`) runs security checks:
- On push to main/master branches
- On pull requests to main/master branches
- Weekly (scheduled) to catch newly discovered vulnerabilities

#### Composer Scripts

We've added the following scripts to `composer.json`:

```json
"scripts": {
    "security:sast": "phpstan analyse",
    "security:phpcs": "phpcs --standard=PSR12,Security --extensions=php Modules",
    "security:deps": "security-checker security:check",
    "security:check": [
        "@security:sast",
        "@security:phpcs",
        "@security:deps"
    ]
}
```

These scripts allow developers to run security checks manually.

## Getting Started

### For New Developers

1. Clone the repository
2. Run `composer install` to install PHP dependencies
3. Run `npm install` to install Node.js dependencies
4. Run `npm run setup-security` to set up the pre-commit hooks

### Running Security Checks Manually

```bash
# Run all security checks
composer security:check

# Run individual checks
composer security:sast     # Static analysis with PHPStan
composer security:phpcs    # Code style and security checks
composer security:deps     # Dependency vulnerability checks
```

## Best Practices

1. **Regular Updates**: Keep dependencies updated to minimize security vulnerabilities
2. **Fix Issues Promptly**: Address security issues as soon as they're identified
3. **Progressive Enhancement**: Gradually increase PHPStan level as codebase quality improves
4. **Security Mindset**: Consider security implications during development

## Troubleshooting

### Common PHPStan Issues

1. **Property does not exist**: Ensure properties are properly declared or use property annotations
2. **Method return type**: Add proper return type declarations to methods
3. **Undefined variable**: Initialize variables before use

### Bypassing Pre-commit Hooks

In rare cases when you need to bypass the pre-commit hooks:

```bash
git commit --no-verify -m "Your commit message"
```

Note: This should only be used in exceptional circumstances, and the commit should be reviewed carefully.

## Future Enhancements

1. Increase PHPStan level gradually (aim for level 8)
2. Add more specialized security rules
3. Integrate with security monitoring services
4. Implement automated security fix suggestions 