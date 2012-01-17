#!/bin/sh
projroot=$(cd $(dirname $0)/.. && pwd)
(
	cd $projroot
	tidy -q -modify -indent -asxhtml \
		index.html \
		family.php
)
