Logoscorp API RATE


API Endpoint

If you want to make a request to the API you should do it at the following address: www.domain.com/rest/V1/logoscorp/rate/update.

The request must be made with POST method.


API Call Payload

You must specify the request parameters in a body with a JSON format like this:

{
    "rates":[
        {
        "code":"EUR",
        "exchange": 3000
        },
        {
        "code":"VEF",
        "exchange": 4000
        }
    ]
}


This JSON-formatted request body includes a rates object with the currency code and the exchange rate. The information in this request body is used to update the currency exchange rate (this is indicated as a code in the request parameter) in the Magento store.


API Response 

You will receive a response in an array format like this:

[
    {
        "code": "EUR",
        "exchange": 300,
        "status": true
    },
    {
        "code": "VEF",
        "exchange": 4000,
        "update": true
    }
]


That array contains in its entirety all the codes for the currency that was sent in the API request. For each currency code, an "exchange" property is shown, the rate with which it was updated, and an "update" property that indicates with a boolean value if the rate for that currency code was updated