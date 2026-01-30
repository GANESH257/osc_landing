# Git Commands to Push to New Branch

## Step-by-Step Commands

Run these commands in your terminal from the project root (`/Applications/MAMP/htdocs/lpnew`):

### 1. Update remote repository URL
```bash
git remote set-url origin git@github.com:GANESH257/osc_landing.git
```

### 2. Verify remote is updated
```bash
git remote -v
```

### 3. Create and switch to a new branch (e.g., "feature/otp-implementation")
```bash
git checkout -b feature/otp-implementation
```

Or use a different branch name:
```bash
git checkout -b develop
# or
git checkout -b main-updated
```

### 4. Stage all changes (respects .gitignore - excludes .env, vendor/, *.zip, etc.)
```bash
git add .
```

### 5. Check what will be committed (optional but recommended)
```bash
git status
```

### 6. Commit all changes
```bash
git commit -m "Add OTP verification, form validations, reCAPTCHA v3, and CallRail tracking"
```

### 7. Push to the new branch on GitHub
```bash
git push -u origin feature/otp-implementation
```

(Replace `feature/otp-implementation` with your chosen branch name)

---

## Alternative: If you want to push to main branch

If you prefer to push directly to main:

```bash
git checkout main
git add .
git commit -m "Add OTP verification, form validations, reCAPTCHA v3, and CallRail tracking"
git push -u origin main
```

---

## Quick One-Liner Sequence

```bash
cd /Applications/MAMP/htdocs/lpnew && \
git remote set-url origin git@github.com:GANESH257/osc_landing.git && \
git checkout -b feature/otp-implementation && \
git add . && \
git commit -m "Add OTP verification, form validations, reCAPTCHA v3, and CallRail tracking" && \
git push -u origin feature/otp-implementation
```

---

## Notes

- `.env` file is excluded (already in .gitignore)
- `vendor/` directory is excluded (Composer dependencies - install on server)
- `*.zip` files are excluded (deployment packages)
- All documentation files (`.md`) will be included
- All code changes will be included
