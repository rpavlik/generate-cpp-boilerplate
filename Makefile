
tocopy := favicon_16.png favicon_32.png favicon_48.png favicon.ico

.PHONY: all
all: recurse $(tocopy)

recurse:
	${MAKE} -C sources/favicon/

$(tocopy): % : sources/favicon/%
	cp $< $@


.PHONY: clean
clean:
	${MAKE} -C sources/favicon/ clean
