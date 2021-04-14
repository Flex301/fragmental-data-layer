## Task details from here

https://www.innertrends.com/hiring/software-engineer-0

## Context:

   There is a system that processes large amounts of raw data (logs) about users activity, from a given time span,  into a more  simplified and coherent form. (A data layer that can  be used by the application to satisfy specific queries with speed and ease)

   The raw data is stored in a 3rd party data lake: a cloud database accessed using an API. It supports advanced queries and their results can be downloaded in files for further processing.
  

## Limitation:

   Using this API we can query and get years of data, but an error gets thrown if a data limit (in mb), collected per user, is reached. Let's call it Data Limit Per User (DLPU) 

   To work around this problem we must split our queries in smaller chunks of time. 

   For example if we wanted to retrieve 1 year  of activity,  we could do 12 api calls: one for each month.
 

## System:

The system has to execute 4 stages to construct this Data Layer:

Calculate the time chunks
Query and download data using 1-n API   calls using intervals from 1.
If DLPU is not reached go to 4. otherwise got to 1. again and split into smaller chunks starting from the problematic period.
Process the collected data
 

## The Need:

We are going to be focusing now on the 1. stage and implement a Solution that takes into account the  DLPU problem:

- The Solution should be able to:

  1.1. receive the initial period (a start date and an end date)

  1.2. calculate  an  array of time intervals (  [[start,end]]  that encompass the provided initial period) that need to be used for queries via API   

  1.3. return the calculated intervals

  1.4. receive a time interval/entry , from 1.3 , and calculate smaller time intervals from that point on ( returnable again with 1.3). This is called when DLPU is reached.

  1.5. return a json with all calculations and intervals that can be stored for later use. ( let's call it full json  that will draw us a full picture of what happened)

  1.6. receive the full json  and directly extract/reconstruct from it the final array of working intervals (returnable with 1.3) . This is used if at a later point in time we want to use the exact same initial period.

- The maximum period size for a chunk is 30 days.
- The minimum period size for a chunk  is 1 hour.
- The beginning of the day is considered : 00:00:00
- The end of the day is considered : 23:59:59
- Initially the used period size for a chunk starts as the maximum limit.
- Each time we recalculate the intervals we cut the used period size in half, rounded
- The Solution ca be implemented in php however you want - just use the php 7.2+ standards.

