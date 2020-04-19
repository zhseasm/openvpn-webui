#!/usr/bin/env bash
wget https://www.flash.cn/cdm/latest/flash-player-npapi-release.x86_64.rpm
wget https://www.flash.cn/cdm/latest/flash-player-ppapi-release.x86_64.rpm
rpm -ivh flash-player-npapi-release.x86_64.rpm
rpm -ivh flash-player-ppapi-release.x86_64.rpm