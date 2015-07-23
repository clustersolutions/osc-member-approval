--------------------------------------------

A Member Approval Addon Moduel For OSC BS.

Author: Cluster Solutions, Copyright 2015

Released under the GNU General Public License

---------------------------------------------

Tested on Edge...one core file change in admin.

https://www.clustersolutions.net/23edge/

Some requirements: Imagick, write permission, and the jQuery file upload tool is modified and included. Ref. https://github.com/blueimp/jQuery-File-Upload/wiki

What it does?

A self-contained login and registration module that allows a member to upload registration documents for the admin after creating an account. The admin can approve or disapprove the account.

Installation:

1) tar over catalog.
2) Uninstall/disable all other login/registration modules.
3) Install Modules->Content->Member Approval Registration.
4) Install Modules->Header Tags->Member Approval Header & Footer Scripts.
5) Install Modules->Dashboard->Customers For Approval.
6) In catalog/admin/includes/boxes/customers.php, replace: 
   
       'link' => tep_href_link(FILENAME_CUSTOMER)
   
   with:
    
       'link' => tep_href_link('customers_member_approval.php') 

Initial release, additional documentation to come...
