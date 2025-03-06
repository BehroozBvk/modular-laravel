# Husky Compatibility Guide

## Understanding Husky Deprecation Warnings

If you encounter the following warning when trying to commit:

```
husky - DEPRECATED

Please remove the following two lines from .husky/pre-commit:

#!/usr/bin/env sh
. "$(dirname -- "$0")/_/husky.sh"

They WILL FAIL in v10.0.0
```

This is because Husky v9+ is deprecating the old hook format that included the line `. "$(dirname -- "$0")/_/husky.sh"`.

## How We Fixed It

We've updated our pre-commit hook to be compatible with the latest Husky version by:

1. Removing the deprecated line `. "$(dirname -- "$0")/_/husky.sh"`
2. Keeping only the shebang line and the actual script content
3. Using `#!/usr/bin/env sh` instead of `#!/bin/sh` for better cross-platform compatibility

## Our Current Hook Format

Our pre-commit hook now follows this format:

```sh
#!/usr/bin/env sh

echo "Running security checks before commit..."

# Script content...
```

## If You Still See Errors

If you still encounter Husky-related errors after running `npm run setup-security`, try the following:

1. Ensure you have the latest version of Husky installed:
   ```bash
   npm install husky@latest --save-dev
   ```

2. Reinstall Husky hooks:
   ```bash
   npx husky init
   npm run setup-security
   ```

3. Manually verify the pre-commit hook:
   ```bash
   cat .husky/pre-commit
   ```
   
   Make sure it doesn't contain the deprecated line `. "$(dirname -- "$0")/_/husky.sh"`.

## Future-Proofing

As Husky continues to evolve, we'll need to keep our hook scripts updated. The project maintainers have indicated that in v10.0.0, the old format will fail completely.

Our current implementation is compatible with Husky v9+ and should continue to work with future versions. 