#!/bin/sh

PASS=true

echo "\nValidating PHPCS:\n"

which ./vendor/bin/phpcs &> /dev/null
if [ $? -eq 1 ]; then
  echo "\033[41mPlease install PHPCS\033[0m"
  exit 1
fi

docker compose run --rm php ./vendor/bin/phpcs --standard=./phpcs.xml

if [ $? -eq 0 ]; then
  echo "\033[32mPHPCS Passed! \033[0m"
else
  echo "\033[41mPHPCS Failed! \033[0m"
  PASS=false
fi

echo "\nPHPCS validation completed!\n"

if ! $PASS; then
  echo "\033[41mCOMMIT FAILED:\033[0m Your commit contains files that should pass PHPCS but do not. \n"
  echo "\033[41mCOMMIT FAILED:\033[0m Please fix the PHPCS errors and try again.\n"
  exit 1
else
  echo "\033[42mCOMMIT SUCCEEDED\033[0m\n"
fi

exit $?
