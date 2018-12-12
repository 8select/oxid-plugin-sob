#!/usr/bin/env bash -e
. $(dirname "$0")/lib/common.sh

if [ "$#" -ne 2 ]; then
    echo "Illegal number of parameters"
    echo "Usage:"
    echo "bin/release.sh <version> <profile>"
    exit 1
fi

. $(dirname "$0")/lib/build.sh

cd ${BUILD_DIR}
zip -q -r "${DIST_PATH}" ${PLUGIN_NAME}
echo "created release ${VERSION} at ${DIST_PATH}"
