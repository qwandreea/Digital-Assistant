# Digital assistant app Laravel Project - README #

### Creare tabele din comenzile artisan ###
* Navigare catre directorul radacina
* Running Migrations [Documentatie Laravel](https://laravel.com/docs/8.x/migrations)
* To run all of your outstanding migrations, execute the migrate Artisan command: php artisan migrate
* If you would like to see which migrations have run thus far, you may use the migrate:status Artisan command: php artisan migrate:status
* Forcing Migrations To Run In Production: Some migration operations are destructive, which means they may cause you to lose data. In order to protect you from running these commands against your production database, you will be prompted for confirmation before the commands are executed. To force the commands to run without a prompt, use the --force flag: php artisan migrate --force

### Introducere ###

* Aplicația **Digital assistant** are la bază următoarele tehnologii: 
* PHP 7.4.16
* Laravel Framework 8.40.0
* MySQL Ver 14.14
* HTML5, CSS3, Bootstrap 4, Javascript și Jquery.

### Descriere problemă ###

* Aplicația **Digital assistant** reprezintă un serviciu software din sfera medicală și are ca principală funcționalitate, verificarea simptomelor și generarea unui diagnostic pe baza unor parametrii selectați de utilizator.
* S-a întâmplat ca de multe ori câteva simptome să persiste și să te deranjeze? Așadar, aplicația se face utilă în a verifica dacă aceste simptome prezintă o gravitate, furnizează un diagnostic sau mai multe pe baza acestora și redă multe alte informații relevante.
* Dacă simptomele prezintă un *redflag*, atunci afli că este cazul să consulți un medic urgent sau să urmezi medicamentația sugerată.

### Workflow ###
* Pasul 1: Autenficarea/Înregistrarea unui cont de utilizator din secțiunea header-ului paginii principale.
* Pasul 2: Accesare secțiunea Subscription pentru achiziția unui pachet de verificări de diagnostic. Fără un pachet achiziționat, nu se pot face verificări.
* Pasul 3: Din secțiunea Dashboard, se accesează butonul de verificare de diagnostic.
* Pasul 4: Se introduc parametrii ceruți din formular, iar aplicația va returna rezultatele găsite.

### Descriere API  ###
* Pentru implementaree, am utilizat 2 API-uri/servicii Cloud: PayPal API și ApiMedic API.
* **REST API - PayPal**: 
    - PayPal oferă o modalitate prin care aplicații, coșuri de cumpărături, sisteme de raportare și site-urile web pot comunica programatic cu PayPal. Acest tip de comunicare are loc prin API. API-ul poate face o mulțime de lucruri - cum ar fi verificarea soldului PayPal, căutarea detaliilor tranzacției, emiterea de rambursări etc.
    - Pentru utilizarea acestui serviciu, am avut nevoie de următoarele set-up-uri:
        - Crearea unui cont sandbox de developer din [PayPal Developer](https://developer.paypal.com/)
        - Din sectiunea App&Credentials se va crea noua aplicație.
        - Se vor genera un Client ID și Secret Key ce se vor utiliza pentru autentificarea ca PayPal developer mode.
        - După introducerea credențialelor în variabilele fișierului .env (pentru securitate) din aplicație, a fost necesar să mai instalez un SDK Paypal cu o comandă specifică Laravel: composer require paypal/rest-api-sdk-php. 
        - Avantajul utilizării unui SDK față de o integrare directă este că SDK gestionează autentificarea obținând tokenul de acces OAuth 2.0 și SDK reflectă automat orice actualizare a API-ului de plată. 
    - Fluxul de date va fi detaliat în secțiunea **Flux de date**.
* **REST API - ApiMedic**: 
    - ApiMedic oferă un instrument de verificare a simptomelor medicale în primul rând pentru pacienți. Pe baza simptomelor introduse, îi spune pacientului ce posibile boli are. Îl direcționează către mai multe informații medicale și arată medicul potrivit pentru clarificări suplimentare. Verificatorul de simptome poate fi integrat prin intermediul API-ului flexibil. Aceasta este o interfață de programare modulară, care oferă funcționalități de verificare a simptomelor pentru un program principal.
    - Pentru utilizarea acestui serviciu, am avut nevoie de următoarele set-up-uri:
        - Abonare la [portalul pentru developeri](https://apimedic.com/signup)
        - Obțineți acreditărilor de test pentru a accesa mediul de testare, care conține toate funcționalitățile sistemului.
        - Din secțiunea API KEYS, sunt furnizate următoarele variabile pentru endpoint: Sandbox Auth-Service, Sandbox Health-Service, Sandbox Username, Sandbox Password.
    - Fluxul de date va fi detaliat în secțiunea **Flux de date**.

### Flux de date ###
* **REST API - PayPal**:
* În apelurile API REST, se include adresa URL a serviciului API pentru mediu:
* Sandbox: https://api-m.sandbox.paypal.com
* Live: https://api-m.paypal.com
    1. Exemple de request / response
        - *REQUEST 1 - Acest exemplu de apel execută obținerea unui token cu <client_id> <secret> furnizate* 
            - POST https://api-m.sandbox.paypal.com/v1/oauth2/token -u "AU8bzYsvQtyEIEZ0OH1DzoDc8vVmZYIifQYrBiTqe1OeCTROIstjnY8P2GcPxvvb1ZLmwr7QljgjaVGW:EJ-yiEOfUxpTQcXO6E7DOtpxC55XzygJqVBiN96bZ_yroK5JkeBUJfNKCr8jCQxGl731Kem2Jb20H-ZH" \ -d "grant_type=client_credentials"
        - *RESPONSE 1 - Răspunsul arată tokenul creat*
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
        - *RESPONSE 2 - Răspusul arată statusul comenzii* <br/>
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
        - *REQUEST 3 - Acest exemplu de apel arată starea comenzii și alte detalii despre comanda creată*
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
        - *Metoda REQUEST 1 - POST - Înregistrare token*
            - Primul request foloseste metoda HTTP 'POST'. Se precizează ca parametrii de autentificare "client_id:secret_key", iar in body "grant_type=client_credentials". Metoda returneaza un JSON ce contine campurile: scope, access_token, app_id, expires_in, nonce.
        - *Metoda REQUEST 2 - POST - Înregistrare comandă*
            - Acest request foloseste metoda HTTP 'POST'. Se precizează ca parametru token-ul, iar în body se trimit valorile atributelor din body-ul json-ului de mai sus pentru request-ul 
        - *Metoda REQUEST 3 - GET*
            - Acest request foloseste metoda HTTP 'GET'. Se precizează ca parametrii id-ul plății înregistrare din request-ul de post, token-ul și id-ul plătitorului. <br/>
    3. Autentificare si autorizare servicii utilizate
        - Pentru a putea folosi metodele acestui serviciu, este necesara o autentificare si o autorizare.
        - Pentru autentificare se va folosi metoda REQUEST 1, care executa un POST cu client_id si secret_key generate la crearea aplicatiei.
        - Token-ul furnizat trebuie utilizat in headerul request-urilor pentru autorizare. Token-ul are un id si un tip: Bearer.
* **REST API - ApiMedic**: 
    1. Exemple de request / response
         - *REQUEST 1 - Acest exemplu de apel execută obținerea listei de simptome* 
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
         - *REQUEST 2 - Acest exemplu de apel execută obținerea descrierii pentru un diagnostic*
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
         - *REQUEST 3 - Acest exemplu de apel execută obținerea diagnosticului*
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
         - *REQUEST 4 - Acest exemplu de apel verifică dacă un simptom e urgent*
            -GET https://sandbox-healthservice.priaid.ch/redflag?symptomId=181&token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im1vZ29zYW5kcmVlYTk5NUB5YWhvby5jb20iLCJyb2xlIjoiVXNlciIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL3NpZCI6IjkwNDQiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3ZlcnNpb24iOiIyMDAiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xpbWl0IjoiOTk5OTk5OTk5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwIjoiUHJlbWl1bSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbGFuZ3VhZ2UiOiJlbi1nYiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvZXhwaXJhdGlvbiI6IjIwOTktMTItMzEiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL21lbWJlcnNoaXBzdGFydCI6IjIwMjEtMDUtMDMiLCJpc3MiOiJodHRwczovL3NhbmRib3gtYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTYyMDQ5NzA3OSwibmJmIjoxNjIwNDg5ODc5fQ.YKAQp0aPEAQ05900EwkG609tWSNiWAO8Mistq03eGqg&format=json&language=en-gb
         - *RESPONSE 4* <br/>
    ```
    "You have selected a symptom which requires a prompt check with a medical doctor."
    ```
    2. Metode HTTP
        - *Metoda REQUEST 1 - GET - Listă simptome*
            - Se precizează ca parametrii de autentificare un token.
        - *Metoda REQUEST 2 - GET - Descrierea pentru un diagnostic*
            - Se precizează ca parametru token-ul și id-ul diagnosticului.
        - *Metoda REQUEST 3 - POST - Diagnostic*
            - Se precizează ca parametrii token-ul, un array cu id-ul simptomelor selectate, anul nasterii și sexul.
        - *Metoda REQUEST 4 - GET - Verificare simptom*
            - Se precizează ca parametrii token-ul și id-ul simptomului.
    3. Autentificare și autorizare servicii utilizate
            - Pentru a putea folosi metodele acestui serviciu, este necesara o autentificare si o autorizare. 
            - Autentificarea este realizată prin api key-uri și există o funcție în aplicație care face acest lucru
            - Autorizarea este furnizată prin token-ul (jetonul) utilizat în fiecare request ca parametru
            
* **Capturi ecran aplicație** <br/>
![Landing page](/public/images/LandingPage.png "Landing page")
![Login](/public/images/Login.PNG "Login form")
![Register](/public/images/Register.PNG "Register form")
![Subscription](/public/images/Subscription.PNG "Subscription form")
![Symptom checker](/public/images/Symptom checker.PNG "Symptoms form")
![Diagosis](/public/images/Diagnosis.PNG "Diagnosis")
![Diagosis](/public/images/Diagnosis2.PNG "Diagnosis")
* **Referinte**
[PayPal Developer](https://developer.paypal.com/docs/api/overview/)
[ApiMedic](https://apimedic.com/)
