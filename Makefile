
tocopy := favicon_16.png favicon_32.png favicon_48.png favicon.ico

phpfiles := \
           download.php \
           family.php \
           generate.php \
           support/attachment.php \
           support/sanitize.php \
           external/guid.php

all: recurse $(tocopy)

check: phplint

recurse:
	${MAKE} -C sources/favicon/

$(tocopy): % : sources/favicon/%
	cp $< $@

clean:
	${MAKE} -C sources/favicon/ clean

phplint:
	@for fn in $(phpfiles); do \
	  php -l $$fn ;\
	done

.PHONY: all recurse clean check phplint
