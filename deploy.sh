#!/bin/bash

# Create the log directory and update permissions
mkdir -m777 tools/integrator/getresponse/log/

# Pull the latest changes from the git repository
# git reset --hard
# git clean -df
git pull origin master

# Install/update composer dependecies
#composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install node modules
npm install

# Build assets with Webpack
npm run production
