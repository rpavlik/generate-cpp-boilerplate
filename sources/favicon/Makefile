#! make

# requires gnu make and a reasonably recent inkscape

# commands
INKSCAPE=@echo "\n[EXPORTING] $@" && inkscape --without-gui --file=$<
ICOTOOL=icotool
PNGCRUSH=pngcrush 

# Sizes to generate
sizes := 16 32 48

input := favicon.svg
output := favicon.ico

png_outputs := $(patsubst %,favicon_%.png,$(sizes))

all_output := $(png_outputs) $(output)

all: $(output)

clean:
	rm -f $(all_output) $(patsubst %,%.tmp,$(png_outputs))

$(png_outputs): favicon_%.png : $(input) $(MAKEFILE)
	$(INKSCAPE) --export-width=$* --export-height=$* --export-png=$@.tmp
	$(PNGCRUSH) $@.tmp $@ && rm $@.tmp

$(output): $(png_outputs)
	icotool -c -o $@ $^


.PHONY: all clean
