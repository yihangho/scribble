#!/bin/bash
echo "Running all tests for controllers"
CONTROLLER_TESTS=app/Test/Case/Controller/*Test.php
for test in $CONTROLLER_TESTS
do
	if [[ $test =~ ^app/Test/Case/Controller/([[:alpha:]]+)Test\.php$ ]]; then
		app/Console/cake test app Controller/${BASH_REMATCH[1]}
		if [[ "$?" != 0 ]]; then
			exit 1
		fi
	fi
done

echo "Running all tests for models"
MODEL_TESTS=app/Test/Case/Model/*Test.php
for test in $MODEL_TESTS
do
	if [[ $test =~ ^app/Test/Case/Model/([[:alpha:]]+)Test\.php$ ]]; then
		app/Console/cake test app Model/${BASH_REMATCH[1]}
		if [[ "$?" != 0 ]]; then
			exit 1
		fi
	fi
done
