# THIS HAS BEEN DEPRECATED SINCE THE SERVICE HAS ENABLED A CAPTCHA

# chalmers-card-balance
Public REST API for checking account balance of Chalmers Student Union cards

## Installation


Add ``johanwinther/chalmers-card-balance`` as a require dependency in your ``composer.json`` file:

    composer require johanwinther/chalmers-card-balance
    
Rename .htaccess.tmp to .htaccess and set the RewriteBase to the absolute folder path of card.php.

# API
## **Show Card Balance**
  Returns JSON data of card balance.

* **URL**

  `/<Card number>`

* **Method:**

  `GET`

*  **URL Params**

   **Required:**

   `Card number` - 16-digit Student Union card number

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ``` json
    {
        "cardHolder": "Emil Emilsson",
        "cardNumber": "1111222233334444",
        "cardBalance": {
            "value": 200.01,
            "currency": "kr"
        }
    }
    ```

* **Error Response:**

  * **Code:** 400 BAD REQUEST <br />
    **Content:**
    ``` json
    {
        "error": "Invalid card number: should be 16 digits."
    }
    ```
    **Explanation:** Request was not 16 digits.

  OR

  * **Code:** 404 NOT FOUND <br />
    **Content:**
    ``` json
    {
        "error": "Invalid card number: card not found."
    }
    ```
    **Explanation:** Card is not registered in the system.

   OR
   * **Code:** 408 REQUEST TIMED OUT <br />
     **Content:**
     ``` json
     {
         "error": "Connection timed out."
     }
     ```
     **Explanation:** Could not load external service.

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "https://ftek.se/api/v1/1111222233334444",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
