# target
set :application, "easyBill"
set :domain,      "195.154.9.83"
set :deploy_to,   "/home/www-data/src/#{application}"
set :app_path, "app"

set :use_composer, true
set :model_manager, "doctrine"
set :php_bin, "/usr/bin/php"

# connection
set :use_sudo, false
set :user, "root"
#set :password, "$PASSWORD"

# deploy strategy
set :scm, :git
set :repository,  "ssh://root@195.154.9.83:/home/unrtech/repo/#{application}.git"
set :branch, "develop"
set :deploy_via, :rsync_with_remote_cache

role :web, domain # Your HTTP server, Apache/etc
role :app, domain # This may be the same as your `Web` server
role :db, domain, :primary => true # This is where Symfony2 migrations will run

# user preferences
set :keep_releases, 5
set :dump_assetic_assets, false
set :update_vendors, false

# shared files
set :shared_files, ["app/config/parameters.yml"]

# shared children
set :shared_children, [app_path + "/logs", "vendor"]
set :writable_dirs, [app_path + "/cache", app_path + "/logs"]

# perform tasks after deploying
after "deploy" do
  # clear the cache
  run "cd /home/www-data/src/#{application}/current && php app/console cache:clear"

  # dump assets (if using assetic)
  run "cd /home/www-data/src/#{application}/current && php app/console assets:install"
  run "cd /home/www-data/src/#{application}/current && php app/console assetic:dump"
  
  run "chown -hR www-data:www-data /home/www-data/src/#{application}/current"
  run "chown -hR www-data:www-data /home/www-data/src/#{application}/current/*"
  run "chmod -R 0777 /home/www-data/src/#{application}/current/app/logs/*"
  run "chmod -R 0777 /home/www-data/src/#{application}/current/app/cache/prod/*"
  run "chmod -R 0777 /home/www-data/src/#{application}/current/app/cache/prod"
end
