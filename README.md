# Event Discovery & Ticketing Platform

A web platform where users can explore various events and purchase tickets. The site features numerous events ranging from music festivals to concerts. Users can view event dates, venues, and ticket prices, select preferred events, and complete ticket purchases seamlessly.

---

## Main Features

### 1. Navigation Bar (Navbar)

**A) Before User Login:**

- **Redirect to Sign In Page:** Clicking the ‘Sign In’ button takes the user to the login page.
- **Redirect to Sign Up Page:** Clicking the ‘Sign Up’ button takes the user to the registration page.

**B) After User Login:**

- **Profile Information:** Click ‘Profile’ to access the profile page, where users can change their password and select their interests.
- **Notifications:** Click ‘Notification’ to view notifications sent by the admin.
- **Cart:** Click ‘My Cart’ to see events added to the user's cart.
- **Logout:** Click ‘Exit’ to safely log out.

---

### 2. Weather and Recommendations Section

- **Weather Information:** Displays current weather conditions and indicates suitability for events. The date and time set by the system are displayed in the bottom left corner.
- **Recommended Events:** Based on the interests selected in the profile, event recommendations are shown on the homepage.

---

### 3. Events Section

- **Event List:** The homepage lists upcoming events in Antalya through API integration, sorted by date and type (music, theater, etc.).
- **Event Details:** Displays event name, date, time, venue, and address.
- **Ticket Purchase:** Users can buy tickets directly via the ‘Get Ticket’ button.

---

### 4. Footer

- **Back to Top Button:** Scrolls the page back to the top.
- **Terms & Conditions:** Displays the website’s general terms and policies.

---

## Registration Screen

Users register by entering email, password, and password confirmation, and accepting the website’s terms and policies. After registration, users are redirected to the login screen awaiting admin approval. Once approved, users are guided to their profile page to change their password and select interests.

---

## Login Screen

Users and admins can log in with their email and password.

---

## Cart Screen

Users can view events in their cart with details including event date and time, event name, ticket category, event price (varies by ticket category), and ticket quantity (up to 10 tickets). Each event section has a trash icon to remove the event from the cart. Clicking ‘Buy The Ticket’ redirects users to the payment page. If the cart is empty, a “Your cart is empty” message is displayed.

---

## Payment Page

Displays total ticket count and total amount according to selected ticket categories and available payment methods (credit card, debit card, PayPal). Users enter card details to complete payment. After payment, users are redirected to the homepage and receive a notification confirming their ticket purchase.

---

## Admin Page

Admins can view registered users, list events, add new events, view notifications, and send notifications to users.

### Main Features:

1. **View Users:**

- Clicking ‘Show The Users’ lists registered users.
- Users can be deleted or approved for registration.

2. **View Events:**

- Clicking ‘List The Activity’ lists published events.
- Events can be deleted or updated.

3. **Add New Event:**

- Clicking ‘CREATE AN EVENT’ opens a form to enter event name, category, type, date, time, venue, address, country, city, capacity, and price, to create a new event.

4. **View Notifications:**

- Clicking ‘SHOW THE NOTIFICATIONS’ displays previously created notifications.

5. **Create Announcement:**

- Clicking ‘SEND A NOTIFICATION’ opens a text editor to enter the announcement.
- Clicking ‘CREATE’ sends the notification to users.
