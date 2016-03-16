Before deploying:

1. Please create a database 'emp' and import the 'localhost.sql' present in 'ems/database' directory.
Database configurations are saved in db_connection.php

2. This app sends an activation link through email, I have used Gmail and have provided the login credentials.
If you need to use your own email id (should be gmail) then  make sure to turn on "Allow less secure apps in Gmail" by visiting the following links :

About allowing less secure apps - https://support.google.com/accounts/answer/6010255?hl=en
link to turn on 'less secure apps' - http://www.google.com/settings/security/lesssecureapps

and provide your credentials (email id and password) in mail.php  

----


#Developers Guide

**index.php** is the test file.  
please change the **$baseUrl** and test the web services of RapidFunnel.  
Base URL for the QA env is **http://qa1.rapidfunnel.com**

##general terms:
```text
status            - true/false. if true then request is success else false.  
errorMessage      - if 'status' is false then you will get a errorMessage.  
userId            - Loggedin user ID  
accountId         - Loggedin user's account ID   
firstName         - First name of the logged in user    
lastName          - Last name of logged in user    
role              - logged in users role    
forceChange       - If the user has asked for password change then it will be 1 else 0.  
                    if 1 then redirect the user to change   password screen else redirect as normal user    
accessToken       - This is the token for the loggedin user to maintain identity like we do in  
                    session. For every login there will be a different accessToken created in backend.  
                    This is the most required param in RapidFunnel web services.  
temporaryPassword - Temp password for the user who requested for forgot password.
```
Methods:
----------

Login API
----------
url: http://www.rapid-funnel.com/api/login
Method: POST
param: username, password
Response:
{"response":
	{"status":"true",
         "mobileLogo":"http://my.rapidfunnel.com/uploads/branding/account/1/mobileLogo_1436273614.png",
	 "content": {
			"userId":"65",
			"accountId":"1",
			"firstName":"Biswa",
			"lastName":"Maji",
			"role":"account-user",
			"forceChange":"0",
			"accessToken":"3c1b9690c9b8d4290ca51eaa585a2a83"
                        "accountInfo": {
                                "accountLevel":"paid"
                                "ignoreUserPayment":"0",
                                "passThrough":"1",               /********** Please check comment below *************/
                                "trialPeriod" = '1';
                                "trialPeriodTill" = "2015-05-20";
                                "freeEnterpriseProUser" : "1"
                        }
		}
	}
}

"For accountInfo data":
accountLevel might have two values
- "free" (Their top level account is of free type)
- or "paid" (account can be of type business or enterprise etc...)
If the accountLevel is of type paid then there will be "ignoreUserPayment" in response
"ignoreUserPayment" : it means, the user's payment ignored, this can be done by application admin only
response values (1, 0)
if ignoreUserPayment = 0, then we check for account is passThrough(means users need to pay for their account)
or account is in trialPeriod, values could be {1, 0}
trialPeriodTill a date say "2015-05-20"
"freeEnterpriseProUser": If user is of enterprise pro level account and passthrough on and has not paid
then they automatically become "freeEnterpriseProUser", they have limited access to resources.


Forgot Password:
----------------
Url: http://www.rapid-funnel.com/api/login/forgot-password
Method: POST
Param: email
Response:
{"response":
	{"status":"true",
         "content": {
			"userId":"65",
			"email":"biswajitm@mindfiresolutions.com",
			"firstName":"Biswa",
			"lastName":"Maji",
			"temporaryPassword":"4e4e7f"
		}
	}
}

LogOut API:
----------------
Url: http://www.rapid-funnel.com/api/login/logout-users
Method: POST
Param: userId, accessToken,
Response:
{"response":
	{"status":"1"}
}

Change Password:
----------------
Url: http://www.rapid-funnel.com/api/login/forgot-password
Method: POST
Param: userId, accessToken, password, confirmPassword
Response:
{"response":
	{"status":"true",
         "content": {
			"userId":"65",
			"forceChange":"0"
		}
	}
}

Get contactResourceCampaignRewardCount:
----------------
Url: http://www.rapid-funnel.com/api/login/contact-resource-campaign-reward-count
Method: POST
Param: userId, accessToken
Response:
{"response":
	{"status":"true",
         "content": {
			"ContactCurrentMonth":"1",
			"ContactLastMonth":"6000",
			"ContactCurWeek":"0",
			"TotalContact":"6001",
			"TotalReward":0,
			"TotalResources":7,
			"TotalCampaign":1
		}
	}
}

----------- Old API request and response for contact -----------

 Add Contact:
 Phone: Mobile, Home, Work, Other (There can be multiple of any of these types)
 phone -> Mobile
 Email: Primary, Home, Work, Other (There can be only one "Primary" and that is
 where Campaigns and Broadcasts will go for that Contact)
 email -> primaryEmail
 ------------
 Url:http://local.rapid-funnel.com/api/account-contact/add-contact
 Method: POST
 Param: {
     accessToken,
     email: "test.email@gmail.com",
     homeEmail: "test.home@gmail.com,test.home2@gmail.com",
     workEmail: "test.work@gmail.com,test.work2@gmail.com",
     otherEmail: "test.test@gmail.com,test.other2@gmail.com",
     firstName,
     lastName,
     note,
     noteTimeStamps: {
       "0": '2016-02-26 19:07:12'
       //User's local time(UTC/GMT)
     },
     phone: "732-757-2920",
     home: "732-757-2922,732-757-2923",
     work: "732-757-2924,732-757-2925",
     other: "732-757-2926,732-757-2927",
     userId,
     zip
 }
 Response:
 {
     "response": {
         "status": "true",
         "content": {
             "message": "Contact added successfully",
             "contactId": "55"
         }
     }
 }

 Get Contact:
 Contacts having multiple phone number(mobile)
 the first number will be returned as phone number
 ------------
 Url:http://local.rapid-funnel.com/api/account-contact/get-contact
 Method: POST
 Param: accessToken, userId
 Response:
 {
     "response": {
         "status": "true",
         "content": {
             "contacts": [
                 {
                     "id": "1",
                     "accountId": "1",
                     "firstName": "Test1",
                     "lastName": "Test1",
                     "email": "test.email@gmail.com",
                     "homeEmail": "test.home@gmail.com,test.home2@gmail.com",
                     "workEmail": "test.work@gmail.com,test.work2@gmail.com",
                     "otherEmail": "test.test@gmail.com,test.other2@gmail.com",
                     "phone": "732-757-2920",
                     "home": "732-757-2922,732-757-2923",
                     "work": "732-757-2924,732-757-2925",
                     "other": "732-757-2926,732-757-2927"
                     "zip": "90900",
                     "note": "test note",
                     "dateCreated": "2014-07-01 16:51:02",
                     "createdBy": "65",
                     "dateModified": "0000-00-00 00:00:00",
                     "modifiedBy": "65",
                     "campaignId": "33"
                 },
                 {
                     "id": "2",
                     "accountId": "1",
                     "firstName": "saS",
                     "lastName": "ADASD",
                     "email": "test1.email@gmail.com",
                     "homeEmail": "test1.home@gmail.com,test1.home2@gmail.com",
                     "workEmail": "test1.work@gmail.com,test1.work2@gmail.com",
                     "otherEmail": "test1.test@gmail.com,test1.other2@gmail.com",
                     "phone": "732-757-2928",
                     "home": "732-757-2930,732-757-2931",
                     "work": "732-757-2932,732-757-2933",
                     "other": "732-757-2934,732-757-2935",
                     "zip": "90900",
                     "note": "test note2",
                     "dateCreated": "2014-07-01 17:15:30",
                     "createdBy": "65",
                     "dateModified": "0000-00-00 00:00:00",
                     "modifiedBy": "65",
                     "campaignId": "34"
                 }
             ]
         }
     }
 }

 Get contact details:
  Contacts having multiple phone number(mobile) the first number
  will be returned as phone number
 --------------------
 Url: http://local.rapid-funnel.com/api/account-contact/get-contact-details
 Method: POST
 Param: accessToken, contactId, userId
 Response:
 {
     "response": {
         "status": "true",
         "content": {
             "id": "4",
             "accountId": "1",
             "firstName": "fname",
             "lastName": "lname",
             "email": "test.email@gmail.com",
             "homeEmail": "test.home@gmail.com,test.home2@gmail.com",
             "workEmail": "test.work@gmail.com,test.work2@gmail.com",
             "otherEmail": "test.test@gmail.com,test.other2@gmail.com",
             "phone": "732-757-2920",
             "home": "732-757-2922,732-757-2923",
             "work": "732-757-2924,732-757-2925",
             "other": "732-757-2926,732-757-2927",
             "zip": "90900",
             "note": "note",
             "dateCreated": "2014-07-01 17:33:03",
             "createdBy": "65",
             "dateModified": "2014-07-02 17:33:00",
             "modifiedBy": "65",
             "campaignId": "33"
         }
     }
 }

 update contact:
  Contacts having multiple phone number(mobile),
  the first number will be updated through mobile APP

  Contacts having multiple notes,
  the first note will be updated through mobile APP
 ---------------
 Url: http://local.rapid-funnel.com/api/account-contact/update-contact
 Method: POST
 Param: {
     accessToken,
     contactId,
     email: "test.email@test.com",
     homeEmail: "test.home@test.com,test.home2@test.com",
     workEmail: "test.work@test.com,test.work2@test.com",
     otherEmail: "test.other@test.com,test.other2@test.com",
     firstName,
     lastName,
     note,
     noteTimeStamps: {
         "0": '2016-02-26 19:07:12'
         //User's local time(UTC/GMT)
     },
     phone: "732-757-2920",
     home: "732-757-2922,732-757-2923",
     work: "732-757-2924,732-757-2925",
     other: "732-757-2926,732-757-2927",
     userId,
     zip
 }
 Response:
 {"response":{
    "status":"true",
    "content":{
        "message":"Contact updated successfully"
        }
    }
 }

 Delete contact:
 ---------------
 Url: http://local.rapid-funnel.com/api/account-contact/delete-contact
 Method: POST
 Param: accessToken, contactId, userId
 Response:
 {"response":{
    "status":"true",
    "content":{
        "message":"Contact deleted successfully"
     }
    }
 }

 ----------- End of Old API request and response for contact -----------


 Get Campaigns:
 ---------------
 Url: http://local.rapid-funnel.com/api/account-campaign/get-campaigns
 Method: POST
 Param: accessToken, userId
 Response:
 {"response":{
    "status":"true",
    "content":{
        "campaigns":{
            "id":"3",
            "accountId":"1",
            "name":"TEst name",
            "description":"Descriptions",
            "status":"1",
            "created":"2014-07-10 15:59:06",
            "createdBy":"65",
            "modified":"0000-00-00 00:00:00",
            "modifiedBy":null,
            "totalContacts": "346"
        }
    }
  }
 }

 Get Campaign Details:
 ---------------------
 Url: http://local.rapid-funnel.com/api/account-campaign/get-campaign-details
 Method: POST
 Param: accessToken, userId, campaignId
 Response:
 {"response":{
        "status":"true",
        "content":{
            "id":"3",
            "accountId":"1",
            "name":"TEst name",
            "description":"Descriptions",
            "status":"1",
            "created":"2014-07-10 15:59:06",
            "createdBy":"65",
            "modified":"0000-00-00 00:00:00",
            "modifiedBy":null,
            "totalContacts": "346"
        }
    }
 }

Assign Contact To Campaign
---------------------------
Url: http://local.rapid-funnel.com/api/account-campaign/assign-contact-to-campaign
Method: POST
Param: accessToken, userId, campaignId, contactId
Response:
{"response":{
    "status":"true",
    "content":{
        "message":"Contact has been assign successfully"
    }
}}

validate user registration
--------------------------
Url: http://local.rapid-funnel.com/api/account-campaign/validate-user-registration
Method: POST
Param: email, registrationCode
Response:
{"response":{
    "status":"true",
    "content":{
        "message":"User's details validated successfully"
    }
}}

get new password
----------------
Url: http://local.rapid-funnel.com/api/account-campaign/get-new-password
Method: POST
Param: email, registrationCode, password, confirmPassword
Response:
{"response":{
    "status":"true",
    "content":{
        "message":"Password created successfully"
    }
}}

Get Branding Details
--------------------
Url: http://local.rapid-funnel.com/api/account-branding/get-details
Method: POST
Param: accessToken, userId
Response:
{"response":{
    "status":"true",
    "content":{
        "id":"3",
        "accountId":"1",
        "dashboardLogo":"dashboardLogo_1409830112.jpg",
        "mobileLogo":"mobileLogo_1409830112.jpg",
        "colorScheme":"#2623e7",
        "mobileLogoPath":"uploads\/branding\/account\/mobileLogo_1409830112.jpg",
        "mobileLogoUrl":"http:\/\/local.rapid-funnel.com\/uploads\/branding\/account\/mobileLogo_1409830112.jpg",
        "dashboardLogoPath":"uploads\/branding\/account\/dashboardLogo_1409830112.jpg",
        "dashboardLogoUrl":"http:\/\/local.rapid-funnel.com\/uploads\/branding\/account\/dashboardLogo_1409830112.jpg"
    }
}}

To Get Incentive listing for an user by running status (active or inactive)
----------------------------------------------------
Url: <Site-Url>/api/account-award/get-incentives
Method: POST
Param: accessToken, userId, runningStatus(1-current, 0- for past)
Response: It will list all incentives based on running status.
{"response":{
    "status":"true",
    "content":[
        {
            "incentiveId":"4",
            "name":"sip 1",
            "startDate":"01\/20\/2015",
            "endDate":"01\/30\/2015",
            "award":"20",
            "goal":null,
            "topPercentage":null,
            "awardTypeId":"1",
            "awardType":"Award for the most leads"
        },
        {
            "incentiveId":"8",
            "name":"past programme",
            "startDate":"01\/01\/2015",
            "endDate":"01\/02\/2015",
            "award":"past",
            "goal":null,
            "topPercentage":null,
            "awardTypeId":"1",
            "awardType":"Award for the most leads"
        }
    ]}
}

To Get Current Awards(Incentive) Details for an user
----------------------------------------------------
Url: <Site-Url>/api/account-award/get-current-award-detail
Method: POST
Param: accessToken, userId, incentiveId
Response: It will vary very little based on the incentive or award type. Please check below.

Award for most leads:
---------------------
{"response":
    {
        "status":"true",
        "content":{
            "incentiveId":"18",
            "accountId":"1",
            "name":"Award 2",
            "startDate":"01\/27\/2015",
            "endDate":"09\/09\/2015",
            "award":"12",
            "goal":null,
            "awardToPerformersInTop":"10",
            "awardTypeId":"1",
            "awardType":"Award for the most leads",
            "leadsGenerated":"8",
            "daysLeft":"203",
            "rank":1,
            "rankPercentage":100
        }
    }
}
Award per lead:
---------------------
{"response":{
    "status":"true",
    "content":{
        "incentiveId":"26",
        "accountId":"1",
        "name":"future award per lead",
        "startDate":"02\/06\/2015",
        "endDate":"04\/23\/2015",
        "award":"20",
        "goal":null,
        "awardToPerformersInTop":null,
        "awardTypeId":"3",
        "awardType":"Award per lead",
        "leadsGenerated":"3",
        "daysLeft":"64",
        "moneyEarned":60
        }
    }
}
Award For Achieving Goal
------------------------
{"response":{
    "status":"true",
    "content":{
        "incentiveId":"1",
        "accountId":"1",
        "name":"award 1",
        "startDate":"01\/18\/2015",
        "endDate":"03\/21\/2015",
        "award":"5",
        "goal":"100",
        "awardToPerformersInTop":null,
        "awardTypeId":"2",
        "awardType":"Award for achieving goal",
        "leadsGenerated":"10",
        "daysLeft":"31",
        "leadsRequired":90,
        "progressPercentage":10
        }
    }
}
If Error:
---------
{"response":{
    "status":"false",
    "errorMessage":"ERROR MESSAGE"
    }
}

To Get Past Awards(Incentive) Details for an user
----------------------------------------------------
Url: <Site-Url>/api/account-award/get-past-award-detail
Method: POST
Param: accessToken, userId, incentiveId
Response:
{"response":
    {"status":"true",
    "content":{
            "name":"Past Award",
            "startDate":"01\/29\/2015",
            "endDate":"01\/31\/2015",
            "award":"22.2345678",
            "goal":null,
            "topPercentage":null,
            "awardTypeId":"3",
            "awardType":"Award per lead",
            "leadsGenerated":"1",
            "awardsEarned":"1"
        }
    }
}

To Get generated leads in a date range of an user
----------------------------------------------------
Url: <Site-Url>/api/account-award/get-generated-leads-by-date-range
Method: POST
Param: accessToken, userId, startDate, endDate
Response:
{"response":
    {"status":"true",
    "content":{
            "leadCount":"2"
        }
    }
}

To Get resources of an user
----------------------------------------------------
Url: <Site-Url>/api/account-resource/get-resource
Method: POST
Param: accessToken, userId
Response:
{"response":
    {"status":"true",
    "content":[
	{
		"id":"2",
		"name":"rs 1 ",
		"accountResourceTypeId":"8",
		"link":"http:\/\/bis.rapidfunnel.com\/api\/account-resource\/get-resource.jpg",
		"typeImage":"account-resource-type-link.jpg",
                "category" : "sports",
		"groups":"group acc1"
	},
	{
		"id":"2",
		"name":"rs 1 ",
		"accountResourceTypeId":"8",
		"link":"http:\/\/bis.rapidfunnel.com\/api\/account-resource\/get-resource.jpg",
		"typeImage":"account-resource-type-link.jpg",
                "category" : "movies",
		"groups":"group acc1"
	}
    ]}
}

--------- New API request and response for contacts ----------------

Add Contact:
 Phone: Mobile, Home, Work, Other (There can be multiple of any of these types)
 phone -> Mobile
 Email: Primary, Home, Work, Other (There can be only one "Primary" and that is
 where Campaigns and Broadcasts will go for that Contact)
 email -> primaryEmail
 ------------
 Url:http://local.rapid-funnel.com/api/account-contact-new/add-contact
 Method: POST
 Param: {
     accessToken,
     email: "test.email@gmail.com",
     homeEmail: "test.home@gmail.com,test.home2@gmail.com",
     workEmail: "test.work@gmail.com,test.work2@gmail.com",
     otherEmail: "test.test@gmail.com,test.other2@gmail.com",
     firstName,
     lastName,
     contactNotes: {
         "0": "note one",
         "1": "note two",
         "2": "note three"
     },
     //Should follow respective noteTimeStamp order
     noteTimeStamps: {
         "0": "2014-12-04 10:43:01",
         "1": "2014-12-05 10:43:01",
         "2": "2014-12-06 10:43:01"
     },
     //Should in ascending order
     phone: "732-757-2920,732-757-2921",
     home: "732-757-2922,732-757-2923",
     work: "732-757-2924,732-757-2925",
     other: "732-757-2926,732-757-2927",
     userId,
     zip
 }
 Response:
 {"response":{
    "status":"true",
    "content":{
        "message":"Contact added successfully",
        "contactId":"55"
        }
    }
 }

Add Contact Notes:
-------------------
Url:http://local.rapid-funnel.com/api/account-contact-new/add-contact-notes
Method: POST
 Param: {
     accessToken,
     contactId,
     userId,
     contactNotes: {
         "0": "note one",
         "1": "note two",
         "2": "note three"
     },
     //Should follow respective noteTimeStamp order
     noteTimeStamps: {
         "0": "2014-12-04 10:43:01",
         "1": "2014-12-05 10:43:01",
         "2": "2014-12-06 10:43:01"
     },
     //Should in ascending order
 }

 Response:
 {"response":{
    "status":"true",
    "content":{
        "message":"Notes Added successfully.",
        }
    }
 }

Get Contact:
 ------------
 Url:http://local.rapid-funnel.com/api/account-contact-new/get-contact
 Method: POST
 Param: accessToken, userId
 Response:
 {
     "response": {
         "status": "true",
         "content": {
             "contacts": [
                 {
                     "id": "1",
                     "accountId": "1",
                     "firstName": "Test1",
                     "lastName": "Test1",
                     "email": "test.email@gmail.com",
                     "homeEmail": "test.home@gmail.com,test.home2@gmail.com",
                     "workEmail": "test.work@gmail.com,test.work2@gmail.com",
                     "otherEmail": "test.test@gmail.com,test.other2@gmail.com",
                     "phone": "732-757-2920,732-757-2921",
                     "home": "732-757-2922,732-757-2923",
                     "work": "732-757-2924,732-757-2925",
                     "other": "732-757-2926,732-757-2927"
                     "zip": "90900",
                     "dateCreated": "2014-07-01 16:51:02",
                     "createdBy": "65",
                     "dateModified": "0000-00-00 00:00:00",
                     "modifiedBy": "65",
                     "campaignId": "33"
                 },
                 {
                     "id": "2",
                     "accountId": "1",
                     "firstName": "saS",
                     "lastName": "ADASD",
                     "email": "test1.email@gmail.com",
                     "homeEmail": "test1.home@gmail.com,test1.home2@gmail.com",
                     "workEmail": "test1.work@gmail.com,test1.work2@gmail.com",
                     "otherEmail": "test1.test@gmail.com,test1.other2@gmail.com",
                     "phone": "732-757-2928,732-757-2929",
                     "home": "732-757-2930,732-757-2931",
                     "work": "732-757-2932,732-757-2933",
                     "other": "732-757-2934,732-757-2935",
                     "zip": "90900",
                     "dateCreated": "2014-07-01 17:15:30",
                     "createdBy": "65",
                     "dateModified": "0000-00-00 00:00:00",
                     "modifiedBy": "65",
                     "campaignId": "34"
                 }
             ]
         }
     }
 }

 Get Contact Notes:
  ------------
  Url:http://local.rapid-funnel.com/api/account-contact-new/get-contact-notes
  Method: POST
  Param: accessToken, userId
  Response:
 {
     "response": {
         "status": "true",
         "content": {
             "contactNotes": [
                 {
                     "noteId": "4",
                     "contactId": "216",
                     "note": "Test5",
                     "noteTimeStamp": "2016-02-22 16:25:52"
                 },
                 {
                     "noteId": "5",
                     "contactId": "217",
                     "note": "Test4",
                     "noteTimeStamp": "2016-02-22 16:20:57"
                 }
             ]
         }
     }
 }

 Get contact details:
 --------------------
 Url: http://local.rapid-funnel.com/api/account-contact-new/get-contact-details
 Method: POST
 Param: accessToken, contactId, userId
 Response:
 {
     "response": {
         "status": "true",
         "content": {
             "id": "4",
             "accountId": "1",
             "firstName": "fname",
             "lastName": "lname",
             "email": "test.email@gmail.com",
             "homeEmail": "test.home@gmail.com,test.home2@gmail.com",
             "workEmail": "test.work@gmail.com,test.work2@gmail.com",
             "otherEmail": "test.test@gmail.com,test.other2@gmail.com",
             "phone": "732-757-2920,732-757-2921",
             "home": "732-757-2922,732-757-2923",
             "work": "732-757-2924,732-757-2925",
             "other": "732-757-2926,732-757-2927",
             "zip": "90900",
             "dateCreated": "2014-07-01 17:33:03",
             "createdBy": "65",
             "dateModified": "2014-07-02 17:33:00",
             "modifiedBy": "65",
             "campaignId": "33"
         }
     }
 }

 Get Contact Specific Notes:
 --------------------
 Url: http://local.rapid-funnel.com/api/account-contact-new/get-contact-note-details
 Method: POST
 Param: accessToken, contactId, userId
 Response:
{
    "response": {
        "status": "true",
        "content": {
            "contactNotes": [
                {
                    "id": "20",
                    "contactNote": "Test3",
                    "noteTimeStamp": "2016-02-26 19:07:08"
                },
                {
                    "id": "21",
                    "contactNote": "Test4",
                    "noteTimeStamp": "2016-02-26 19:07:12"
                }
            ]
        }
    }
}

 update contact:
 ---------------
 Url: http://local.rapid-funnel.com/api/account-contact-new/update-contact
 Method: POST
 Param: {
     accessToken,
     contactId,
     email: "test.email@test.com",
     homeEmail: "test.home@test.com,test.home2@test.com",
     workEmail: "test.work@test.com,test.work2@test.com",
     otherEmail: "test.other@test.com,test.other2@test.com",
     firstName,
     lastName,
     phone: "732-757-2920,732-757-2921",
     home: "732-757-2922,732-757-2923",
     work: "732-757-2924,732-757-2925",
     other: "732-757-2926,732-757-2927",
     userId,
     zip
 }
 Response:
 {"response":{
     "status":"true",
     "content":{
         "message":"Contact updated successfully"
         }
     }
  }

  update contact notes:
  ---------------
  Url: http://local.rapid-funnel.com/api/account-contact-new/update-contact-notes
  Method: POST
  Param: {
      accessToken,
      contactId,
      userId,
      noteIds: {
          "0": 10,
          "1": 11,
          "2": 12
      },
      contactNotes: {
          "0": "note one",
          "1": "note two",
          "2": "note three"
      },
      noteTimeStamps: {
          "0": "2014-12-04 10:43:01",
          "1": "2014-12-05 10:43:01",
          "2": "2014-12-06 10:43:01"
      }
  }

Response:
{
    "response": {
        "status": "true",
        "content": {
            "message": "Notes updated successfully"
        }
    }
}


 Delete contact:
 ---------------
 Url: http://local.rapid-funnel.com/api/account-contact-new/delete-contact
 Method: POST
 Param: accessToken, contactId, userId
 Response:
  {"response":{
     "status":"true",
     "content":{
         "message":"Contact deleted successfully"
      }
     }
  }

  Delete contact notes:
  ---------------
  Url: http://local.rapid-funnel.com/api/account-contact-new/delete-contact-notes
  Method: POST
  Param: {
    accessToken,
    contactId,
    userId,
    noteIds: {
        "0": 10,
        "1": 11,
        "2": 12
    },
  }

  Response:
  {"response":{
     "status":"true",
     "content":{
         "message":"Notes deleted successfully"
      }
     }
  }

 ---------- End of New API request and response -------------------
