# WDA---Web-Application-for-Hotel-Search
Read world fully functional web app for Hotel Search and Booking. I had to develop this project in order to acquire the CollegeLink Academy Web Development Certification.

WDA-Project
Web Development Academy 2021 by CollegeLink.gr

This project is one real world web application project for searching and booking hotel rooms. 


NOTES:

I have used the hotel.sql (in phpMyAdmin database and the xampp server to implement my project).

The stucture of the project is: 

	First of all, one user should register at the sign up-page(register.php) with his data and then log in at the login page(login.php).Then he can use the next pages with a account(user_id).

1. One landing page (index.php) with search filters(city,roomtype,check-in date,check-out date).
	With the submit of the button there will be a redirection to list.php page(Search results page) with the results(available hotels).

2. Search Results page (list.php) with the available rooms (results depending on the filters of the form).

3. 	Page (room.php) with the selected room details and informations (room_id, informations, media, map, description etc.). 
	In this page the user can select this room to his favorites (with the heart icon-input) and also make a review for this room (rate and comment). 
	The user can also book this room for selected dates if it΄s available for this dates.
	
4. Profile page (profile.php) with the user's favorite rooms, reviews and bookings.
