set   :application,   "easyBill"
set   :deploy_to,     "/home/www-data/src/#{application}"

set   :scm,           :git
set   :repository,    "ssh-git-#{application}:/home/unrtech/repo/#{application}.git"

role  :web,           application
role  :app,           application, :primary => true

set   :use_sudo,      false
set   :keep_releases, 3