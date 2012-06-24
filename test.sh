#!/bin/bash
./reset.sh
phpunit -c app/
bin/behat app/features
exit $?
