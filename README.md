# EasyBill
An application for making bills

# Vagrant environment

the project comes with a vagrant environment, here is the virtual machine configuration
<ul>
    <li>ip address : 192.168.33.10</li>
    <li>RAM : 4Go</li>
</ul>
more information inside the Vagrantfile


1. first [install vagrant](http://docs.vagrantup.com/v2/getting-started/index.html)
2. you will need to get the vagrant box
    <pre>vagrant box add ubuntu/trusty64 https://github.com/kraksoft/vagrant-box-ubuntu/releases/download/14.04/ubuntu-14.04-amd64.box</pre>
3. then just launch the vagrant inside the project in terminal
    <pre>vagrant up</pre>
    
After the vagrant machine will up, you just need a web browser and access 
<ul>
    <li>[dev url](http://192.168.33.10/app_dev.php)</li> 
    <li>[prod url](http://192.168.33.10)</li>
</ul>

admin access : admin/admin
user access : bill/bill

