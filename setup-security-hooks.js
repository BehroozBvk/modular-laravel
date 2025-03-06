#!/usr/bin/env node

import { execSync } from "child_process";
import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

console.log("Setting up security hooks for your project...");

// Ensure .husky directory exists
const huskyDir = path.join(process.cwd(), ".husky");
if (!fs.existsSync(huskyDir)) {
    console.log("Initializing Husky...");
    execSync("npx husky init", { stdio: "inherit" });
}

// Create pre-commit hook
const preCommitPath = path.join(huskyDir, "pre-commit");
const preCommitContent = `#!/usr/bin/env sh
. "$(dirname -- "$0")/_/husky.sh"

echo "Running security checks before commit..."

# Get list of staged PHP files
STAGED_PHP_FILES=$(git diff --cached --name-only --diff-filter=ACMR | grep -E '\\.(php)$')

if [ -n "$STAGED_PHP_FILES" ]; then
    echo "Running PHPStan on staged files..."
    # Run PHPStan on staged files only
    echo "$STAGED_PHP_FILES" | xargs vendor/bin/phpstan analyse --no-progress || {
        echo "PHPStan found issues. Please fix them before committing."
        exit 1
    }
    
    echo "Running PHP_CodeSniffer on staged files..."
    # Run PHP_CodeSniffer on staged files only
    echo "$STAGED_PHP_FILES" | xargs vendor/bin/phpcs --standard=PSR12,Security || {
        echo "PHP_CodeSniffer found issues. Please fix them before committing."
        exit 1
    }
fi

# Always check dependencies for vulnerabilities
echo "Checking dependencies for vulnerabilities..."
composer security:deps || {
    echo "Security vulnerabilities found in dependencies. Review them before committing."
    # We don't exit with error here to allow commits even with vulnerable dependencies
    # This is just a warning, but you can change to exit 1 if you want to block commits
}

echo "All security checks passed!"
exit 0
`;

fs.writeFileSync(preCommitPath, preCommitContent);
console.log("Pre-commit hook created successfully.");

// Make the hook executable (for Unix systems)
try {
    execSync(`chmod +x ${preCommitPath}`);
    console.log("Made pre-commit hook executable.");
} catch (error) {
    console.log(
        "Note: On Windows, you don't need to make the file executable."
    );
}

// Update package.json to include prepare script if it doesn't exist
try {
    const packageJsonPath = path.join(process.cwd(), "package.json");
    const packageJson = JSON.parse(fs.readFileSync(packageJsonPath, "utf8"));

    if (!packageJson.scripts) {
        packageJson.scripts = {};
    }

    if (!packageJson.scripts.prepare) {
        packageJson.scripts.prepare = "husky install";
        fs.writeFileSync(packageJsonPath, JSON.stringify(packageJson, null, 2));
        console.log('Added "prepare" script to package.json');
    }
} catch (error) {
    console.error("Error updating package.json:", error);
}

console.log("\nSecurity hooks setup complete!");
console.log(
    "The pre-commit hook will now run security checks before each commit."
);
console.log("To bypass hooks temporarily, use: git commit --no-verify");
