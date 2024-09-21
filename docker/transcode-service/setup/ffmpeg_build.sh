#!/bin/bash

# Install libraries for FFmpeg:
# x264: H.264 Video Codec (MPEG-4 AVC)
#   - libx264
#   - Required:
#     + nasm
# x265: H.265 Video Codec (HEVC)
# ACC (fdk_aac): Fraunhofer FDK AAC Codec
#   - libfdk-aac
# VP8/VP9/webm: VP8 / VP9 Video Codec for the WebM video file format
#   - libvpx
#   - Required:
#     + yasm
# xvidcore: MPEG-4 video coding standard
# mp3: MPEG-1 or MPEG-2 Audio Layer III
#   - libmp3lame (lame)
# ogg: Free, open container format
#   - libogg
# vorbis: Lossy audio compression format
# opus: Lossy audio coding format
# theora: Free lossy video compression format

if [ "$EUID" -ne 0 ]
  then echo "Please run as root"
  exit
fi

CPU_CORE=$(nproc)
HOME_PATH="$HOME"
HOME_ROOT_PATH="/root"
CURRENT_PATH=$(pwd)

WORKSPACE="/var/service-transcode"

if [ $# -gt 0 ]; then
  WORKSPACE="$1"
fi

BUILD_PATH="$WORKSPACE/build"
BIN_PATH="$WORKSPACE/bin"
BUILD_FFMPEG="$BUILD_PATH/ffmpeg"
CACHE_PATH="$BUILD_PATH/cache"
CACHE_PACKAGES="$CACHE_PATH/packages"

mkdir -p $WORKSPACE
mkdir -p $BUILD_PATH
mkdir -p $BIN_PATH
mkdir -p $BUILD_FFMPEG
mkdir -p $CACHE_PATH
mkdir -p $CACHE_PACKAGES

# Set bin path
export PATH=$BUILD_FFMPEG/bin:$PATH
export PKG_CONFIG_PATH="$BUILD_FFMPEG/lib/pkgconfig"

execute() {
  echo "$ $*"

  OUTPUT=$("$@" 2>&1)

  # shellcheck disable=SC2181
  if [ $? -ne 0 ]; then
    echo "$OUTPUT"
    echo ""
    echo "Failed to Execute $*" >&2
    exit 1
  fi
}

download() {
  # download url [filename[dirname]]

  DOWNLOAD_PATH="$CACHE_PACKAGES"
  DOWNLOAD_FILE="${2:-"${1##*/}"}"

  if [[ "$DOWNLOAD_FILE" =~ tar. ]]; then
    TARGETDIR="${DOWNLOAD_FILE%.*}"
    TARGETDIR="${3:-"${TARGETDIR%.*}"}"
  else
    TARGETDIR="${3:-"${DOWNLOAD_FILE%.*}"}"
  fi

  if [ ! -f "$DOWNLOAD_PATH/$DOWNLOAD_FILE" ]; then
    echo "Downloading $1 as $DOWNLOAD_FILE"
    curl -L --silent -o "$DOWNLOAD_PATH/$DOWNLOAD_FILE" "$1"

    EXITCODE=$?
    if [ $EXITCODE -ne 0 ]; then
      echo ""
      echo "Failed to download $1. Exitcode $EXITCODE. Retrying in 10 seconds"
      sleep 10
      curl -L --silent -o "$DOWNLOAD_PATH/$DOWNLOAD_FILE" "$1"
    fi

    EXITCODE=$?
    if [ $EXITCODE -ne 0 ]; then
      echo ""
      echo "Failed to download $1. Exitcode $EXITCODE"
      exit 1
    fi

    echo "... Done"
  else
    echo "$DOWNLOAD_FILE has already downloaded."
  fi

  mkdir -p "$DOWNLOAD_PATH/$TARGETDIR"

  if [[ "$DOWNLOAD_FILE" == *"patch"* ]]; then
    return
  fi

  if [ -n "$3" ]; then
    if ! tar -xvf "$DOWNLOAD_PATH/$DOWNLOAD_FILE" -C "$DOWNLOAD_PATH/$TARGETDIR" 2>/dev/null >/dev/null; then
      echo "Failed to extract $DOWNLOAD_FILE"
      exit 1
    fi
  else
    if ! tar -xvf "$DOWNLOAD_PATH/$DOWNLOAD_FILE" -C "$DOWNLOAD_PATH/$TARGETDIR" --strip-components 1 2>/dev/null >/dev/null; then
      echo "Failed to extract $DOWNLOAD_FILE"
      exit 1
    fi
  fi

  echo "Extracted $DOWNLOAD_FILE"

  cd "$DOWNLOAD_PATH/$TARGETDIR" || (
    echo "Error has occurred."
    exit 1
  )
}

build() {
  echo ""
  echo "building $1 - version $2"
  echo "======================="
  CURRENT_PACKAGE_VERSION=$2

  if [ -f "$CACHE_PACKAGES/$1.done" ]; then
    if grep -Fx "$2" "$CACHE_PACKAGES/$1.done" >/dev/null; then
      echo "$1 version $2 already built. Remove $CACHE_PACKAGES/$1.done lockfile to rebuild it."
      return 1
    elif $LATEST; then
      echo "$1 is outdated and will be rebuilt with latest version $2"
      return 0
    else
      echo "$1 is outdated, but will not be rebuilt. Pass in --latest to rebuild it or remove $CACHE_PACKAGES/$1.done lockfile."
      return 1
    fi
  fi

  return 0
}

build_done() {
  echo "$2" >"$CACHE_PACKAGES/$1.done"
}

############################################## INSTALL

CONFIGURE_OPTION=""

gcc_ver=`gcc -dumpversion | awk -F. '{print $1}'`

if [ ${gcc_ver} -ge 6 ]; then
    # for x264, libvpx, ffmpeg
    ENABLE_PIC="--enable-pic"
    CONFIGURE_OPTION=${ENABLE_PIC}
fi

###### autoconf
if build "autoconf" "2.71"; then
  download "https://ftp.gnu.org/gnu/autoconf/autoconf-2.71.tar.gz"
  execute ./configure \
    --prefix="$BUILD_FFMPEG"
  execute make -j${CPU_CORE}
  execute make install
  build_done "autoconf" "2.71"
fi

###### yasm
if build "yasm" "1.3.0"; then
  download "https://github.com/yasm/yasm/releases/download/v1.3.0/yasm-1.3.0.tar.gz"
  execute ./configure --prefix="${BUILD_FFMPEG}"
  execute make -j${CPU_CORE}
  execute make install
  build_done "yasm" "1.3.0"
fi

###### nasm
if build "nasm" "2.16.01"; then
  download "https://www.nasm.us/pub/nasm/releasebuilds/2.16.01/nasm-2.16.01.tar.gz"
  execute ./autogen.sh
  execute ./configure \
    --prefix="$BUILD_FFMPEG" \
    --bindir="$BUILD_FFMPEG/bin"
  execute make -j${CPU_CORE}
  execute make install
  execute make distclean
  build_done "nasm" "2.16.01"
fi

###### x264
if build "x264" "latest"; then
  download "https://code.videolan.org/videolan/x264/-/archive/master/x264-master.tar.gz"
  execute ./configure \
    --prefix="$BUILD_FFMPEG" \
    --bindir="$BUILD_FFMPEG/bin" \
    --enable-static ${ENABLE_PIC}
  execute make -j${CPU_CORE}
  execute make install
  execute make distclean

  build_done "x264" "latest"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libx264"

###### x265
if build "x265" "3.5"; then
  download "https://github.com/videolan/x265/archive/Release_3.5.tar.gz"
  cd build/linux
  execute cmake -G "Unix Makefiles" \
    -DCMAKE_INSTALL_PREFIX="$BUILD_FFMPEG" \
    -DENABLE_SHARED:bool=off ../../source
  execute make -j${CPU_CORE}
  execute make install

  build_done "x265" "3.5"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libx265"

###### AAC
if build "fdk-aac" "2.0.2"; then
  download "https://github.com/mstorsjo/fdk-aac/archive/v2.0.2.tar.gz"
  execute autoreconf -fiv
  execute ./configure \
    --prefix="$BUILD_FFMPEG" \
    --disable-shared
  execute make -j${CPU_CORE}
  execute make install
  execute make distclean

  build_done "fdk-aac" "2.0.2"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libfdk-aac"

###### VP9
if build "libvpx" "1.13.0"; then
  download "https://github.com/webmproject/libvpx/archive/refs/tags/v1.13.0.tar.gz" "libvpx-1.13.0.tar.gz"

  if [[ "$OSTYPE" == "darwin"* ]]; then
    echo "Applying Darwin patch"
    sed "s/,--version-script//g" build/make/Makefile >build/make/Makefile.patched
    sed "s/-Wl,--no-undefined -Wl,-soname/-Wl,-undefined,error -Wl,-install_name/g" build/make/Makefile.patched >build/make/Makefile
  fi

  execute ./configure \
    --prefix="${BUILD_FFMPEG}" \
    --disable-unit-tests \
    --disable-shared \
    --disable-examples \
    --as=yasm \
    --enable-vp9-highbitdepth
  execute make -j${CPU_CORE}
  execute make install

  build_done "libvpx" "1.13.0"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libvpx"

###### xvidcore
if build "xvidcore" "1.3.7"; then
  download "https://downloads.xvid.com/downloads/xvidcore-1.3.7.tar.gz"
  cd build/generic || exit
  execute ./configure \
    --prefix="${BUILD_FFMPEG}" \
    --disable-shared \
    --enable-static
  execute make -j${CPU_CORE}
  execute make install

  if [[ -f ${BUILD_FFMPEG}/lib/libxvidcore.4.dylib ]]; then
    execute rm "${BUILD_FFMPEG}/lib/libxvidcore.4.dylib"
  fi

  if [[ -f ${BUILD_FFMPEG}/lib/libxvidcore.so ]]; then
    execute rm "${BUILD_FFMPEG}"/lib/libxvidcore.so*
  fi

  build_done "xvidcore" "1.3.7"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libxvid"

###### mp3
if build "lame" "3.100"; then
  download "https://sourceforge.net/projects/lame/files/lame/3.100/lame-3.100.tar.gz/download?use_mirror=gigenet" "lame-3.100.tar.gz"
  execute ./configure \
    --prefix="${BUILD_FFMPEG}" \
    --disable-shared \
    --enable-static
  execute make -j${CPU_CORE}
  execute make install

  build_done "lame" "3.100"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libmp3lame"

### Install ogg
if build "ogg" "1.3.5"; then
  download "https://ftp.osuosl.org/pub/xiph/releases/ogg/libogg-1.3.5.tar.xz"
  execute ./configure \
    --prefix="${BUILD_FFMPEG}" \
    --disable-shared --enable-static
  execute make -j${CPU_CORE}
  execute make install

  build_done "ogg" "1.3.5"
fi

if build "libvorbis" "1.3.7"; then
  download "https://ftp.osuosl.org/pub/xiph/releases/vorbis/libvorbis-1.3.7.tar.gz"
  execute ./configure \
    --prefix="${BUILD_FFMPEG}" \
    --with-ogg-libraries="${BUILD_FFMPEG}"/lib \
    --with-ogg-includes="${BUILD_FFMPEG}"/include/ \
    --enable-static \
    --disable-shared \
    --disable-oggtest
  execute make -j${CPU_CORE}
  execute make install

  build_done "libvorbis" "1.3.7"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libvorbis"

if build "opus" "1.3.1"; then
  download "https://archive.mozilla.org/pub/opus/opus-1.3.1.tar.gz"
  execute ./configure \
    --prefix="${BUILD_FFMPEG}" \
    --disable-shared \
    --enable-static
  execute make -j${CPU_CORE}
  execute make install

  build_done "opus" "1.3.1"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libopus"

if build "libtheora" "1.1.1"; then
  download "https://ftp.osuosl.org/pub/xiph/releases/theora/libtheora-1.1.1.tar.gz"

  execute ./configure \
    --prefix="${BUILD_FFMPEG}" \
    --with-ogg-libraries="${BUILD_FFMPEG}"/lib \
    --with-ogg-includes="${BUILD_FFMPEG}"/include/ \
    --with-vorbis-libraries="${BUILD_FFMPEG}"/lib \
    --with-vorbis-includes="${BUILD_FFMPEG}"/include/ \
    --enable-static \
    --disable-shared \
    --disable-oggtest \
    --disable-vorbistest \
    --disable-examples \
    --disable-asm \
    --disable-spec
  execute make -j${CPU_CORE}
  execute make install
  execute make clean

  build_done "libtheora" "1.1.1"
fi

CONFIGURE_OPTION="${CONFIGURE_OPTION} --enable-libtheora"

###### FFmpeg
if build "ffmpeg" "6.0"; then
  download "https://github.com/FFmpeg/FFmpeg/archive/refs/heads/release/6.0.tar.gz"
  ./configure \
    --prefix="$BUILD_FFMPEG" \
    --extra-cflags="-I$BUILD_FFMPEG/include" \
    --extra-ldflags="-L$BUILD_FFMPEG/lib" \
    --extra-libs="-lm -lpthread" \
    --bindir="$BUILD_FFMPEG/bin" \
    --pkg-config-flags="--static" \
    --disable-debug \
    --disable-shared \
    --enable-gpl \
    --enable-nonfree \
    --enable-libfreetype \
    $CONFIGURE_OPTION

  make -j${CPU_CORE}
  make install
  make distclean
  hash -r

  build_done "ffmpeg" "6.0"
fi

###### Complete
chmod +x "$BUILD_FFMPEG/bin/*"
cp -R "$BUILD_FFMPEG/bin/*" "$BIN_PATH"
cp -R "$BUILD_FFMPEG/bin/*" "/usr/bin"

###### Confirm
ffmpeg -version
