#!/bin/bash
echo "===== START git pull ====="
cd /ssd/html
echo -e "\n"
echo "***** production 수정 내역 *****"
git status
echo -e "\n"
echo "***** 변경 내역 *****"
git fetch
git diff --stat master origin/master
echo -e "\n"
echo -e "merge 하시겠습니까? (y/n)"
read yesno
if ["$yesno" != "y"]; then
  echo "merge 하지 않았습니다."
  exit 1;
else
  git merge origin/master
fi
echo -e "\n"
echo "===== End git pull component2 ====="
