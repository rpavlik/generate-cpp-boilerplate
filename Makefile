
# Customization point: where make build (the default target) sends things to.
BUILD_DIR := staging

# Default target - build a staging tree.
all: build

# Generated files from the SVG of the favicon.
favicon := favicon_16.png favicon_32.png favicon_48.png favicon.ico

# PHP files we should copy and lint.
phpfiles := \
  download.php \
  family.php \
  generate.php \
  support/attachment.php \
  support/sanitize.php \
  external/guid.php

# Source template files
templatefiles := $(wildcard templates/*.tpl)

# All files that should be copied to a staging tree.
build_sources := \
  index.html \
  ICanHaz.min.js \
  $(favicon) \
  $(phpfiles) \
	$(templatefiles)

# Subdirectories we need created in the build directory
out_dirs := support external templates
build_dirs := $(BUILD_DIR) $(patsubst %,$(BUILD_DIR)/%,$(out_dirs))

# Create directories for build/staging tree
$(build_dirs):
	mkdir -p $@

# Copy files into build/staging tree
build_files := $(patsubst %,$(BUILD_DIR)/%,$(build_sources))
$(build_files): $(BUILD_DIR)/% : %
	cp $< $@

build: $(build_dirs) $(build_files)

icon: recurse $(favicon)

check: phplint

$(patsubst %,sources/favicon/%,$(favicon)): sources/favicon/% : sources/favicon/favicon.svg sources/favicon/Makefile
	${MAKE} -C sources/favicon/ $*

recurse:
	${MAKE} -C sources/favicon/
	@for fn in $(favicon); do \
	  cp sources/favicon/$$fn $$fn ;\
	done

#$(favicon): % : sources/favicon/%
#	cp $< $@

clean:
	${MAKE} -C sources/favicon/ clean
	rm -rf $(BUILD_DIR)

phplint:
	@for fn in $(phpfiles); do \
	  php -l $$fn ;\
	done

.PHONY: all build icon recurse clean check phplint
