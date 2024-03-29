# Digital assistant app Laravel Project - README #

### Creating tables from artisan commands ###
* Navigating to the root directory
* Running Migrations [Documentatie Laravel](https://laravel.com/docs/8.x/migrations)
* To run all of your outstanding migrations, execute the migrate Artisan command: php artisan migrate
* If you would like to see which migrations have run thus far, you may use the migrate:status Artisan command: php artisan migrate:status
* Forcing Migrations To Run In Production: Some migration operations are destructive, which means they may cause you to lose data. In order to protect you from running these commands against your production database, you will be prompted for confirmation before the commands are executed. To force the commands to run without a prompt, use the --force flag: php artisan migrate --force

### Introduction ###

*  **Digital assistant** app is based on the following technologies: 
* PHP 7.4.16
* Laravel Framework 8.40.0
* MySQL Ver 14.14
* HTML5, CSS3, Bootstrap 4, Javascript and Jquery.

### Problem description ###

* The **Digital assistant** application is a software service in the medical field, and its main functionality is to check symptoms and generate a diagnosis based on parameters selected by the user.
* Have you ever had persistent and bothersome symptoms? Therefore, the application becomes useful in checking if these symptoms indicate seriousness, providing a diagnosis or more based on them, and providing many other relevant pieces of information.
* If the symptoms raise a red flag, you will know it's time to consult a doctor urgently or follow the suggested medication.

### Workflow ###
* Step 1: Authentication/Registration of a user account from the header section of the main page.
* Step 2: Access the Subscription section to purchase a diagnostic check package. Without a purchased package, checks cannot be performed.
* Step 3: From the Dashboard section, click on the diagnostic check button.
* Step 4: Enter the required parameters in the form, and the application will return the results found.

### API  Description ###
* For implementation, I used 2 cloud APIs/services: PayPal API and ApiMedic API.
* **REST API - PayPal**: 
    - PayPal provides a way for applications, shopping carts, reporting systems, and websites to communicate programmatically with PayPal. This type of communication happens through an API. The API can do many things, such as checking the PayPal balance, retrieving transaction details, issuing refunds, and more.
    - To use this service, we needed the following set-up:
        - Creating a developer sandbox account from [PayPal Developer](https://developer.paypal.com/)
        - Creating a new application from the App & Credentials section.
        - Generating a Client ID and Secret Key, which are used for authentication in PayPal developer mode.
        - After entering the credentials in the application's .env file (for security), it was necessary to install the PayPal SDK with a specific Laravel command: composer require paypal/rest-api-sdk-php.
        - The advantage of using an SDK over a direct integration is that the SDK manages authentication by obtaining the OAuth 2.0 access token, and the SDK automatically reflects any updates to the payment API.
    - The data flow will be detailed in the **Data Flow** section.
* **REST API - ApiMedic**: 
    - ApiMedic offers a medical symptom checker primarily for patients. Based on the entered symptoms, it informs the patient about possible illnesses, directs them to more medical information, and suggests the right doctor for further clarifications. The symptom checker can be integrated through the flexible API, which is a modular programming interface providing symptom-checking functionality for a parent program.
    - To use this service, we needed the following set-up:
        - Signing up on the [developer portal](https://apimedic.com/signup)
        - Obtaining test credentials to access the testing environment, which includes all system functionalities.
        - From the API KEYS section, the following variables are provided for endpoints: Sandbox Auth-Service, Sandbox Health-Service, Sandbox Username, and Sandbox Password.
    - The data flow will be detailed in the  **Data Flow** section.

### Data Flow ###
* **REST API - PayPal**:
* In REST API calls, the API service URL for the environment is included:
* Sandbox: https://api-m.sandbox.paypal.com
* Live: https://api-m.paypal.com
    1. Examples of request/response:
        - *REQUEST 1 - This example call performs token retrieval with the provided* <client_id> and <secret>
            - POST https://api-m.sandbox.paypal.com/v1/oauth2/token -u "AU8bzYsvQtyEIEZ0OH1DzoDc8vVmZYIifQYrBiTqe1OeCTROIstjnY8P2GcPxvvb1ZLmwr7QljgjaVGW:EJ-yiEOfUxpTQcXO6E7DOtpxC55XzygJqVBiN96bZ_yroK5JkeBUJfNKCr8jCQxGl731Kem2Jb20H-ZH" \ -d "grant_type=client_credentials"
        - *RESPONSE 1 -  The response shows the created token*
    <br />
    ```
    {"scope": "https://uri.paypal.com/services/invoicing https://uri.paypal.com/services/vault/payment-tokens/read https://uri.paypal.com/services/disputes/read-buyer https://uri.paypal.com/services/payments/realtimepayment https://uri.paypal.com/services/disputes/update-seller https://uri.paypal.com/services/payments/payment/authcapture openid https://uri.paypal.com/services/disputes/read-seller Braintree:Vault https://uri.paypal.com/services/payments/refund https://api.paypal.com/v1/vault/credit-card https://api.paypal.com/v1/payments/.* https://uri.paypal.com/payments/payouts https://uri.paypal.com/services/vault/payment-tokens/readwrite https://api.paypal.com/v1/vault/credit-card/.* https://uri.paypal.com/services/subscriptions https://uri.paypal.com/services/applications/webhooks",
    "access_token": "A21AAIy7raUhGx644y0LRUmQZ5SZ3zB7FLePz_RXx2FOJ1tER61wXHKu9sw6GKyEvzMW2PImOezMDq84JGNJb7Ae8Vb4KeeSQ",
    "token_type": "Bearer",
    "app_id": "APP-80W284485P519543T",
    "expires_in": 31677,
    "nonce": "2021-05-08T12:00:07ZVmVWth7HFRsoltWX6K-qiGmPCyUPL3JT7J0K-5tY1Js"}
    ```
        - *REQUEST 2 - Acest exemplu de apel execută o comandă cu valoarea și moneda furnizată* 
            - POST https://api-m.sandbox.paypal.com/v2/checkout/orders \ -H "Content-Type: application/json" \ -H "Authorization: A21AAIy7raUhGx644y0LRUmQZ5SZ3zB7FLePz_RXx2FOJ1tER61wXHKu9sw6GKyEvzMW2PImOezMDq84JGNJb7Ae8Vb4KeeSQ" \ -d ' 
            - body: <br />
```{ "intent": "sale","payer": { "payment_method": "paypal" },"redirect_urls": { "return_url": "http://3.238.27.2:8000/status", "cancel_url": "http://3.238.27.2:8000/status" },"transactions": [ { "amount": { "total": "5.00", "currency": "EUR" },"description": "Personal","item_list": { "items": [ { "name": "Personal", "price": "5.00", "currency": "EUR", "quantity": 1 } ] },"related_resources": [] } ],"id": "PAYID-MCLHZJQ11D49943EA625472T","state": "created", "create_time": "2021-05-08T11:57:25Z","links": [ { "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MCLHZJQ11D49943EA625472T","rel": "self", "method": "GET" }, { "href": "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-0FE68891SX992583G","rel": "approval_url", "method": "REDIRECT" }, { "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MCLHZJQ11D49943EA625472T/execute","rel": "execute", "method": "POST" } ] }```
        - *RESPONSE 2 - The response shows the status of the order.* <br/>
 ```{
  "id": "PAYID-MCLH2EI20R3541208921094S",
  "status": "CREATED",
  "links": [
    {
      "href": "https://api-m.paypal.com/v2/checkout/orders/PAYID-MCLH2EI20R3541208921094S",
      "rel": "self",
      "method": "GET"
    },
    {
      "href": "https://www.paypal.com/checkoutnow?token=PAYID-MCLH2EI20R3541208921094S",
      "rel": "approve",
      "method": "GET"
    },
    {
      "href": "https://api-m.paypal.com/v2/checkout/orders/PAYID-MCLH2EI20R3541208921094S",
      "rel": "update",
      "method": "PATCH"
    },
    {
      "href": "https://api-m.paypal.com/v2/checkout/orders/PAYID-MCLH2EI20R3541208921094S/capture",
      "rel": "capture",
      "method": "POST"
    }
  ]
} 
```
        - *REQUEST 3 - This example call displays the order status and other details about the created order.*
            - GET http://3.238.27.2:8000/status?paymentId=PAYID-MCLIFCA4FU57408DT9023625&token=EC-4WK18633FF837550M&PayerID=4TUMXPF593QW2
        - *RESPONSE 3* <br />
    ``` { "id": "PAYID-MCLH2EI20R3541208921094S", 
        "intent": "sale", "state": "approved", 
        "cart": "6W973642KS320212L", 
        "payer": { "payment_method": "paypal", "status": "VERIFIED", "payer_info": { "email": "sb-ky57z1702378@personal.example.com", "first_name": "John", "last_name": "Doe", "payer_id": "4TUMXPF593QW2", "shipping_address": { "recipient_name": "John Doe", "line1": "1 Main St", "city": "San Jose", "state": "CA", "postal_code": "95131", "country_code": "US" }, "country_code": "US" } }, 
        "transactions": [ { "amount": { "total": "5.00", "currency": "EUR", "details": { "subtotal": "5.00", "shipping": "0.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00", "discount": "0.00" } }, "payee": { "merchant_id": "Z2AVY8DZUTT3A", "email": "mogosandreea995@yahoo.com" }, "description": "Personal", "item_list": { "items": [ { "name": "Personal", "price": "5.00", "currency": "EUR", "tax": "0.00", "quantity": 1 } ], "shipping_address": { "recipient_name": "John Doe", "line1": "1 Main St", "city": "San Jose", "state": "CA", "postal_code": "95131", "country_code": "US" } }, "related_resources": [ { "sale": { "id": "6NE17275P0567370D", "state": "completed", "amount": { "total": "5.00", "currency": "EUR", 
        "details": { "subtotal": "5.00", "shipping": "0.00", "insurance": "0.00", "handling_fee": "0.00", "shipping_discount": "0.00", "discount": "0.00" } }, "payment_mode": "INSTANT_TRANSFER", "protection_eligibility": "ELIGIBLE", "protection_eligibility_type": "ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE", 
        "transaction_fee": { "value": "0.45", "currency": "EUR" }, 
        "receivable_amount": { "value": "5.00", "currency": "EUR" }, 
        "exchange_rate": "0.8627555079", 
        "parent_payment": "PAYID-MCLH2EI20R3541208921094S", 
        "create_time": "2021-05-08T12:00:09Z", 
        "update_time": "2021-05-08T12:00:09Z", 
        "links": [ { "href": "https://api.sandbox.paypal.com/v1/payments/sale/6NE17275P0567370D", 
        "rel": "self", "method": "GET" }, { "href": "https://api.sandbox.paypal.com/v1/payments/sale/6NE17275P0567370D/refund",
        "rel": "refund", "method": "POST" }, { "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MCLH2EI20R3541208921094S", 
        "rel": "parent_payment", "method": "GET" } ] } } ] } ], 
        "redirect_urls": { "return_url": "http://3.238.27.2:8000/status?paymentId=PAYID-MCLH2EI20R3541208921094S", 
        "cancel_url": "http://3.238.27.2:8000/status" }, "create_time": "2021-05-08T11:59:13Z", "update_time": "2021-05-08T12:00:09Z", 
        "links": [ { "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MCLH2EI20R3541208921094S", "rel": "self", "method": "GET" } ],"failed_transactions": [] }``` 
    2. Metode HTTP
        - *Metoda REQUEST 1 - POST - Token Registration*
            - The first request uses the HTTP method 'POST.' The authentication parameters are specified as "client_id:secret_key," and in the request body, "grant_type=client_credentials" is provided. The method returns a JSON containing the fields: scope, access_token, app_id, expires_in, nonce.
        - *Metoda REQUEST 2 - POST - Order Registration*
            - This request uses the HTTP method 'POST.' The token is specified as a parameter, and in the request body, the values of the attributes from the JSON body mentioned above for the request are sent.
        - *Metoda REQUEST 3 - GET*
            - This request uses the HTTP method 'GET.' It specifies the payment registration ID from the POST request, the token, and the payer's ID as parameters.. <br/>
    3. Authentication and Authorization of Used Services:
        - To use the methods of this service, authentication and authorization are required.
        - For authentication, REQUEST 1 will be used, which performs a POST with the client_id and secret_key generated during application creation.
        - The provided token must be used in the headers of requests for authorization. The token has an ID and a type: Bearer.
* **REST API - ApiMedic**: 
    1. Examples of request/response:
         - *REQUEST 1 - This example call retrieves a list of symptoms.* 
            - GET https://sandbox-healthservice.priaid.ch/symptoms?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im1vZ29zYW5kcmVlYTk5NUB5YWhvby5jb20iLCJyb2xlIjoiVXNlciIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL3NpZCI6IjkwNDQiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3ZlcnNpb24iOiIyMDAiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xpbWl0IjoiOTk5OTk5OTk5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwIjoiUHJlbWl1bSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbGFuZ3VhZ2UiOiJlbi1nYiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvZXhwaXJhdGlvbiI6IjIwOTktMTItMzEiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL21lbWJlcnNoaXBzdGFydCI6IjIwMjEtMDUtMDMiLCJpc3MiOiJodHRwczovL3NhbmRib3gtYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTYyMDQ4NzE3NiwibmJmIjoxNjIwNDc5OTc2fQ.LKq6ZzfPUoCZkWuoClUAko7jiUWulDK8NbGcPptiv7E&format=json&language=en-gb
         - *RESPONSE 1* <br/>
    ```
    [
    {
        "ID": 76,
        "Name": "Feeling of foreign body in the eye"
    },
    {
        "ID": 11,
        "Name": "Fever"
    },
    {
        "ID": 57,
        "Name": "Going black before the eyes"
    },
    {
        "ID": 9,
        "Name": "Headache"
    },
    {
        "ID": 45,
        "Name": "Heartburn"
    },
    {
        "ID": 122,
        "Name": "Hiccups"
    },
    {
        "ID": 149,
        "Name": "Hot flushes"
    },
    {
        "ID": 40,
        "Name": "Increased thirst"
    },
    {
        "ID": 73,
        "Name": "Itching eyes"
    },
    {
        "ID": 96,
        "Name": "Itching in the nose"
    },
    {
        "ID": 35,
        "Name": "Lip swelling"
    },
    {
        "ID": 235,
        "Name": "Memory gap"
    },
    {
        "ID": 112,
        "Name": "Menstruation disorder"
    },
    {
        "ID": 123,
        "Name": "Missed period"
    },
    {
        "ID": 44,
        "Name": "Nausea"
    },
    {
        "ID": 136,
        "Name": "Neck pain"
    },
    {
        "ID": 114,
        "Name": "Nervousness"
    },
    {
        "ID": 133,
        "Name": "Night cough"
    },
    {
        "ID": 12,
        "Name": "Pain in the limbs"
    },
    {
        "ID": 203,
        "Name": "Pain on swallowing"
    },
    {
        "ID": 37,
        "Name": "Palpitations"
    },
    {
        "ID": 140,
        "Name": "Paralysis"
    },
    {
        "ID": 54,
        "Name": "Reduced appetite"
    },
    {
        "ID": 14,
        "Name": "Runny nose"
    },
    {
        "ID": 29,
        "Name": "Shortness of breath"
    },
    {
        "ID": 124,
        "Name": "Skin rash"
    }
]
    ```
         - *REQUEST 2 - This example call retrieves the description for a diagnosis*
            -GET https://sandbox-healthservice.priaid.ch/issues/495/info?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im1vZ29zYW5kcmVlYTk5NUB5YWhvby5jb20iLCJyb2xlIjoiVXNlciIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL3NpZCI6IjkwNDQiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3ZlcnNpb24iOiIyMDAiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xpbWl0IjoiOTk5OTk5OTk5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwIjoiUHJlbWl1bSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbGFuZ3VhZ2UiOiJlbi1nYiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvZXhwaXJhdGlvbiI6IjIwOTktMTItMzEiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL21lbWJlcnNoaXBzdGFydCI6IjIwMjEtMDUtMDMiLCJpc3MiOiJodHRwczovL3NhbmRib3gtYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTYyMDQ4NzQxOSwibmJmIjoxNjIwNDgwMjE5fQ.ZWPVRSTPJSkcfti75pJedd9cQ2-Gl_jhsnGfcxt_gy8&format=json&language=en-gb
         - *RESPONSE 2* <br/>
    ```
    {
  "Description": "Meteorism is a condition where the abdomen feels full and tight. In this situation, the belly may look swollen and distended.",
  "DescriptionShort": "Meteorism describes the accumulation of gas in the abdomen or in the intestines, accompanied by distention. It is normally not a serious problem. Sometimes, over-the-counter medication is enough to relieve the symptoms. But if meteorism is caused by certain diseases, one should consult a doctor.",
  "MedicalCondition": "Causes of meteorism include 1) swallowing air, 2) constipation, 3) gastro-esophageal reflux (GERD), 4) irritable bowel syndrome, 5) lactose intolerance or problems with digestion, 6) overeating, 7) small bowel bacterial overgrowth, 8) weight gain and 9) weak abdominal muscles. Certain diseases may also cause meteorism. These include ascites and tumors, celiac diseases, dumping syndrome, intestinal obstruction and when the pancreas does not produce enough digestive enzyme.",
  "Name": "Bloated belly",
  "PossibleSymptoms": "Abdominal pain",
  "ProfName": "Meteorism",
  "Synonyms": null,
  "TreatmentDescription": "To relieve the symptom of the feeling of distention in the abdomen, there are multiple over-the-counter drugs. One can avoid meteorism by following some advice: 1) avoid carbonated drinks and food with high levels of fructose or sorbitol, 2) avoid food that can produce gas such as beans, cabbages and the like, 3) do not eat too quickly, 4) stop smoking and 5) work out. If meteorism is caused by an underlying disease, then one should visit a specialist to treat the disease first."
    }
    ```
         - *REQUEST 3 - This example call retrieves the diagnosis.*
            -POST https://sandbox-healthservice.priaid.ch/diagnosis?symptoms=[10,11,12]&gender=female&year_of_birth=22&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im1vZ29zYW5kcmVlYTk5NUB5YWhvby5jb20iLCJyb2xlIjoiVXNlciIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL3NpZCI6IjkwNDQiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3ZlcnNpb24iOiIyMDAiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xpbWl0IjoiOTk5OTk5OTk5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwIjoiUHJlbWl1bSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbGFuZ3VhZ2UiOiJlbi1nYiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvZXhwaXJhdGlvbiI6IjIwOTktMTItMzEiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL21lbWJlcnNoaXBzdGFydCI6IjIwMjEtMDUtMDMiLCJpc3MiOiJodHRwczovL3NhbmRib3gtYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTYyMDQ5NjkzMSwibmJmIjoxNjIwNDg5NzMxfQ.Gcn2vJojPhp4QE4jXVEK3NDyxu4Y-BRaIgBNwc6CHa0&format=json&language=en-gb
         - *RESPONSE 3* <br/>
    ```
    [
  {
    "Issue": {
      "ID": 11,
      "Name": "Flu",
      "Accuracy": 90,
      "Icd": "J10;J11",
      "IcdName": "Influenza due to other identified influenza virus;Influenza, virus not identified",
      "ProfName": "Influenza",
      "Ranking": 1
    },
    "Specialisation": [
      {
        "ID": 15,
        "Name": "General practice",
        "SpecialistID": 0
      },
      {
        "ID": 19,
        "Name": "Internal medicine",
        "SpecialistID": 0
      }
    ]
  },
  {
    "Issue": {
      "ID": 166,
      "Name": "Listeria infection",
      "Accuracy": 12.42857,
      "Icd": "A32",
      "IcdName": "Listeriosis",
      "ProfName": "Listeriosis",
      "Ranking": 2
    },
    "Specialisation": [
      {
        "ID": 15,
        "Name": "General practice",
        "SpecialistID": 0
      },
      {
        "ID": 19,
        "Name": "Internal medicine",
        "SpecialistID": 0
      }
    ]
  },
  {
    "Issue": {
      "ID": 281,
      "Name": "Food poisoning",
      "Accuracy": 10.7142859,
      "Icd": "A05;A02;A03;A04",
      "IcdName": "Other bacterial foodborne intoxications, not elsewhere classified;Other salmonella infections;Shigellosis;Other bacterial intestinal infections",
      "ProfName": "Foodborne illness",
      "Ranking": 3
    },
    "Specialisation": [
      {
        "ID": 15,
        "Name": "General practice",
        "SpecialistID": 0
      },
      {
        "ID": 19,
        "Name": "Internal medicine",
        "SpecialistID": 0
      }
    ]
  }
]
    ```
         - *REQUEST 4 - This example call checks if a symptom is urgent*
            -GET https://sandbox-healthservice.priaid.ch/redflag?symptomId=181&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im1vZ29zYW5kcmVlYTk5NUB5YWhvby5jb20iLCJyb2xlIjoiVXNlciIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL3NpZCI6IjkwNDQiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3ZlcnNpb24iOiIyMDAiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xpbWl0IjoiOTk5OTk5OTk5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwIjoiUHJlbWl1bSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbGFuZ3VhZ2UiOiJlbi1nYiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvZXhwaXJhdGlvbiI6IjIwOTktMTItMzEiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL21lbWJlcnNoaXBzdGFydCI6IjIwMjEtMDUtMDMiLCJpc3MiOiJodHRwczovL3NhbmRib3gtYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTYyMDQ5NzA3OSwibmJmIjoxNjIwNDg5ODc5fQ.YKAQp0aPEAQ05900EwkG609tWSNiWAO8Mistq03eGqg&format=json&language=en-gb
         - *RESPONSE 4* <br/>
    ```
    "You have selected a symptom which requires a prompt check with a medical doctor."
    ```
    2. HTTP Methods
        - *REQUEST 1 - GET - List of Symptoms*
            - Authentication token is specified as a parameter.
        - *REQUEST 2 - GET - Diagnosis Description*
            - Parameters include the token and diagnosis ID.
        - *REQUEST 3 - POST - Diagnosis*
            - Parameters include the token, an array with the selected symptom IDs, birth year, and gender.
        - *REQUEST 4 - GET - Symptom Verification*
            - Parameters include the token and symptom ID.
    3. Authentication and Authorization of Used Services:
            - To use the methods of this service, authentication and authorization are required. 
            - Authentication is performed using API keys, and there is a function in the application that handles this.
            - Authorization is provided through the token used in each request as a parameter.
            
* **App Screenshots.** <br/>
![Landing page](/public/images/LandingPage.png "Landing page")
![Login](/public/images/Login.PNG "Login form")
![Register](/public/images/Register.PNG "Register form")
![Subscription](/public/images/Subscription.PNG "Subscription form")
![Symptom checker](/public/images/Symptom%20checker.PNG "Symptoms form")
![Diagosis](/public/images/Diagnosis.PNG "Diagnosis")
![Diagosis](/public/images/Diagnosis2.PNG "Diagnosis")
* **References**
[PayPal Developer](https://developer.paypal.com/docs/api/overview/)
[ApiMedic](https://apimedic.com/)


© [This project is my personal work.]
