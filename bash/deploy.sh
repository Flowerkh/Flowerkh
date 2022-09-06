# eval $(ssh-agent)
# ssh-add -k ~/.ssh/id_rsa_ntwglobal_ople-mall
/usr/bin/git reset --hard origin/dev
/usr/bin/git clean -f -d
/usr/bin/git pull origin dev
