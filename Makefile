# "all" is name of the default target, running "make" without params would use it
all: buttnet

# for C++, replace CC (c compiler) with CXX (c++ compiler) which is used as default linker
#CC=$(CXX)
CXX=g++
CXXFLAGS=-std=c++11 
# tell which files should be used, .cpp -> .o make would do automatically
buttnet: buttnet.cpp main.cpp
