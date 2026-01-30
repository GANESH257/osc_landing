#!/bin/bash

# Fix push issues for OSC Landing Page
# This script handles common GitHub push rejection scenarios

cd /Applications/MAMP/htdocs/lp

echo "Checking remote repository status..."

# Fetch from remote to see what's there
git fetch origin 2>&1

# Check if remote has content
if git ls-remote --heads origin main 2>/dev/null | grep -q main; then
    echo "Remote repository has content. Pulling and merging..."
    
    # Pull and merge remote changes
    git pull origin main --allow-unrelated-histories --no-edit 2>&1
    
    if [ $? -eq 0 ]; then
        echo "Merge successful. Pushing merged content..."
        git push origin main
    else
        echo "Merge had conflicts or issues."
        echo "Option 1: Force push (WARNING: This will overwrite remote content)"
        echo "  Run: git push origin main --force"
        echo ""
        echo "Option 2: Resolve conflicts manually and then push"
    fi
else
    echo "Remote repository appears empty or doesn't exist."
    echo "Attempting direct push..."
    git push origin main
    
    if [ $? -ne 0 ]; then
        echo ""
        echo "Push failed. Possible solutions:"
        echo ""
        echo "1. If repository has branch protection:"
        echo "   - Go to GitHub repo Settings > Branches"
        echo "   - Temporarily disable branch protection"
        echo "   - Push again"
        echo ""
        echo "2. If you want to overwrite remote content:"
        echo "   git push origin main --force"
        echo ""
        echo "3. Check repository rules:"
        echo "   - Go to GitHub repo Settings > Rules"
        echo "   - Review and adjust rules if needed"
    fi
fi
