set   :application,   "Easy Bill"
set   :deploy_to,     "/home/www-data/src/easyBill"
set   :domain,        "195.154.9.83"

set   :scm,           :git
set   :repository,    "ssh://root@195.154.9.83:/home/unrtech/repo/easyBill.git"

role  :web,           domain
role  :app,           domain, :primary => true

set   :use_sudo,      false
set   :keep_releases, 3