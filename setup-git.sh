#!/bin/bash

# Git setup script for OSC Landing Page
# Run this script from the project directory

cd /Applications/MAMP/htdocs/lp

# Remove existing .git if corrupted
if [ -d .git ]; then
    rm -rf .git
fi

# Initialize git repository
git init

# Rename branch to main
git branch -M main

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit: OSC Landing Page"

# Add remote repository
git remote add origin git@github.com:GANESH257/osc_landing.git

# Push to GitHub
git push -u origin main

echo "Git setup complete!"
