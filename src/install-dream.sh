#!/bin/bash
#
# bootstrap script to install all needed software to generate
# deep dream images on Ubuntu 14.04 (trusty)
#
# /!\ RUN AS ROOT /!\
apt-get -y update
apt-get -y upgrade
apt-get -y install linux-source
apt-get -y install linux-headers-`uname -r`
printf "export PYTHONPATH=$PATH:/opt/caffe/python\nexport PATH=$PATH:/opt/caffe/.build_release/tools" >> /etc/profile
apt-get update && sudo apt-get install -y bc cmake curl gfortran git libprotobuf-dev libleveldb-dev libsnappy-dev libopencv-dev libboost-all-dev libhdf5-serial-dev liblmdb-dev libjpeg62 libfreeimage-dev libatlas-base-dev pkgconf protobuf-compiler python-dev python-pip unzip wget python-numpy python-scipy python-pandas python-sympy python-nose
# update-alternatives --install /usr/bin/cc cc /usr/bin/gcc-4.6 30
# update-alternatives --install /usr/bin/c++ c++ /usr/bin/g++-4.6 30
# update-alternatives --install /usr/bin/gcc gcc /usr/bin/gcc-4.6 30
# update-alternatives --install /usr/bin/g++ g++ /usr/bin/g++-4.6 30
cd /opt && git clone https://github.com/BVLC/caffe.git
cd /opt && wget https://google-glog.googlecode.com/files/glog-0.3.3.tar.gz && tar zxvf glog-0.3.3.tar.gz && cd /opt/glog-0.3.3 && ./configure && make && make install
cd /opt && wget https://github.com/schuhschuh/gflags/archive/master.zip && unzip master.zip && cd /opt/gflags-master && mkdir build && cd /opt/gflags-master/build && export CXXFLAGS="-fPIC" && cmake .. && make VERBOSE=1 && make && make install
cd /opt/caffe && cp Makefile.config.example Makefile.config && echo "CPU_ONLY := 1" >> Makefile.config && echo "CXX := /usr/bin/g++" >> Makefile.config && sed -i 's/CXX :=/CXX ?=/' Makefile && make all
ldconfig
cd /opt/caffe && pip install -r python/requirements.txt
cd /opt/caffe && make pycaffe
cd /opt/caffe && make test && make runtest
/opt/caffe/scripts/download_model_binary.py /opt/caffe/models/bvlc_googlenet
