#!/bin/bash

# Script to completely remove secrets from git history
# This uses git filter-branch to rewrite history

cd /Applications/MAMP/htdocs/lp

echo "Removing secrets from git history..."

# Remove the API key from all commits in history
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch includes/functions.php spine-care/includes/functions.php 2>/dev/null || true" \
  --prune-empty --tag-name-filter cat -- --all

# Add the files back with the cleaned version
git add includes/functions.php spine-care/includes/functions.php
git commit --amend --no-edit

echo "History cleaned. You can now push with: git push origin main --force"
