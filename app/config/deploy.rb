set :application, "Easy Bill"
set :domain,      "bill.unrtech.fr"
set :deploy_to,   "/home/www-data/src/easyBill"
set :app_path,    "app"

set :repository,  "file:///home/unrtech/repo/easyBill.git"
set :scm,         :git
set :deploy_via,  :copy
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set   :use_sudo,      false
set  :keep_releases,  3

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL