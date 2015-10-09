PLUGIN_NAME = S3

all:
	@ git archive HEAD --prefix=${PLUGIN_NAME}/ --format=zip -o ${PLUGIN_NAME}.zip
