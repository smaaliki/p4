# Project 4
+ By: *Samer Maaliki*
+ Production URL: <http://p4.ulaila.com>

## Database

Primary tables:
  + `contactcenters`
  + `employees`
  + `services`
  
Pivot table(s):
  + `contact_center_service`


## CRUD

__Create__
  + Visit <http://p4.ulaila.com/manageCCs/create>
  + Fill out form
  + Click *Add CC*
  + Observe confirmation message

__Read__
  + Visit <http://p4.ulaila.com/ccs> see a listing of all contact centers
  + Visit <http://p4.ulaila.com/employees> see a listing of all employees

__Update__
  + Visit <http://p4.ulaila.com/manageCCs>; choose the Edit icon in the *Actions* column of one of the contact centers
  + Make some edit to form
  + Click *Save*
  + Observe confirmation message

__Delete__
  + Visit <http://p4.ulaila.com/employees>; choose the Delete icon in the *Actions* column of one  of the employees
  + Confirm deletion
  + Observe confirmation message

## Outside resources

Icons used in this Web App:
+ *Phone* by Tom Walsh from the Noun Project
+ *Add* by throwaway icons from the Noun Project
+ *Edit* by throwaway icons from the Noun Project
 
For the Contact Us page:
<https://dev.to/rizwan_saquib/laravel-contact-form-with-email>
 
For form elements:
<https://getbootstrap.com/docs/4.0/components/forms/>
 
For addressing the date input support:
<https://codepen.io/mikedryan/pen/EjWNKj>


## Code style divergences
*None*

## Notes for instructor
The idea for this website is to eventually create a publicly accessible website for residents to view a list of contact centers.  The contact centers would be managed by a super admin who would login to add and manage the contact centers at a high level.  There would also be contact center admins who can only access info related to their contact centers and manage the employees within it.

I used the one to many relationship between contact centers and employees. The pivot table use was between the contact centers and the types of services that they offer.