# -*- mode: ruby -*-
# vi: set ft=ruby :

#vagrant boxes
# vagrant box add ubuntu/trusty64 https://github.com/kraksoft/vagrant-box-ubuntu/releases/download/14.04/ubuntu-14.04-amd64.box

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.define "billServer" do |billServer|
        billServer.vm.box = "ubuntu/trusty64"

        billServer.vm.box_check_update = false

        billServer.vm.provider "virtualbox" do |v|
            v.memory = 4096
        end

        billServer.vm.network "forwarded_port", guest: 80, host: 8081
	    billServer.vm.network "forwarded_port", guest: 443, host: 8043

        billServer.vm.network "private_network", ip: "192.168.33.10"

        billServer.vm.hostname ="easybill-server"

        billServer.ssh.forward_agent = true

        billServer.vm.synced_folder "./", "/var/www/easybill", owner: "www-data", group: "www-data"

	  billServer.vm.provision "shell", path: "provisioning/setup.sh"
    end

end
