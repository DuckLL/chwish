# chwish

Public Key Wish Exchange Platform

[English Version](#english-version)

# 中文版本

交換禮物怕收到垃圾？試試看交換願望！

## 遊戲特色

- 註冊邀請碼機制，不會遇到陌生人
- 帳號密碼全部加密，匿名登入機制
- RSA2048 加密機制，安全隱私有保障
- 自動化遊戲流程，無須管理員介入
- 最長鍊配對機制，避免互相交換

## 安裝方式

1. 重新設定 config.php 中的`$passcode`及`$resetcode`
1. 編輯`docker-compose.yml`外部映射的 port
1. 執行`docker-compose up -d`

# English Version

A platform for wish exchange with friends.

## Features

- Register via invitation code, no strangers.
- Username and password are encrypted, anonymous member mechanism.
- RSA2048 is secure and reliable.
- Automatic game flow without administrator.
- Longest chain exchange mechanism.

## Installation

1. Reset `$passcode` and `$resetcode` in config.php
1. Edit `docker-compose.yml` externally mapped port
1. Execute `docker-compose up -d`
