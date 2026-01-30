# Commands to Fix Secret Leaks and Push to GitHub

## Step 1: Stage all the fixes
```bash
cd /Applications/MAMP/htdocs/lpnew
git add .
```

## Step 2: Commit the fixes
```bash
git commit -m "Remove hardcoded secrets: Use environment variables for API keys"
```

## Step 3: Reset the previous commit(s) that contained secrets
Since GitHub rejected the push, the commits are only local. We need to rewrite history:

### Option A: Interactive Rebase (Recommended)
```bash
# See the last few commits
git log --oneline -5

# Start interactive rebase (replace N with number of commits to edit)
git rebase -i HEAD~N

# In the editor, change "pick" to "edit" for commits with secrets
# Then for each commit:
#   - Make fixes if needed
#   - git add .
#   - git commit --amend --no-edit
#   - git rebase --continue
```

### Option B: Reset and recommit (Simpler, but loses commit history)
```bash
# Soft reset to before the problematic commits
git reset --soft HEAD~N  # Replace N with number of commits

# Stage everything again
git add .

# Create a single clean commit
git commit -m "Add OTP verification, form validations, reCAPTCHA v3, and CallRail tracking

- Implemented OTP verification system for all forms
- Added form validations for brochure download
- Integrated reCAPTCHA v3 for bot protection
- Added CallRail tracking script
- Removed hardcoded API keys (now using environment variables)
- Excluded credentials and deployment packages from git"

# Push to new branch
git push -u origin feature/otp-implementation
```

## Step 4: Verify no secrets remain
```bash
# Check for Brevo API key pattern
git grep -i "xkeysib-" || echo "No Brevo API keys found"

# Check for Google credentials
git ls-files | grep -i credentials.json || echo "No credentials.json in git"
```

## Step 5: Push to GitHub
```bash
git push -u origin feature/otp-implementation
```

---

## What Was Fixed:

1. ✅ **Removed hardcoded Brevo API key** from `includes/functions.php` - now reads from `$_ENV['BREVO_API_KEY']`
2. ✅ **Sanitized all documentation files** - replaced actual API keys with placeholders
3. ✅ **Removed `credentials.json`** from git tracking (added to .gitignore)
4. ✅ **Excluded deployment packages** from git (added to .gitignore)
5. ✅ **Updated .gitignore** to prevent future secret leaks

---

## Important Notes:

- The `.env` file is already excluded (never committed)
- `vendor/` directory is excluded (Composer dependencies)
- All deployment packages are now excluded
- Credentials directory is excluded
