#!/usr/bin/env bash
if [[ $EUID -ne 0 ]];then
echo 'noroot';
fi