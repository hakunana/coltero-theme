#!/bin/bash

sudo rm -r ./humhub/src/*
tar xf ./humhub/humhub-1.2.0-beta.2-ee.tar.gz
cp -r ./humhub-1.2.0-beta.2-ee/* ./humhub/src/
sudo rm -r ./humhub-1.2.0-beta.2-ee
