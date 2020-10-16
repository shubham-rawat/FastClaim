# FastClaim
A Web Dashboard Application for Insurance Claims

# Database Schema and Details

## Create the following tables

### Table 1

CREATE TABLE `claimants` (
  `claim_no` varchar(20) NOT NULL PRIMARY KEY,
  `claimant_name` varchar(50) NOT NULL,
  `offer` varchar(20) NOT NULL,
  `counter_offer` varchar(20) NOT NULL,
  `details` varchar(70) NOT NULL,
  `counter_details` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

### Table 2

CREATE TABLE `claims` (
  `claim_no` varchar(20) NOT NULL PRIMARY KEY,
  `type` varchar(20) NOT NULL,
  `details` varchar(50) NOT NULL,
  `color` varchar(20) NOT NULL,
  `stage` varchar(20) NOT NULL,
  `adjuster` varchar(20) NOT NULL,
  `supervisor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

### Table 3

CREATE TABLE `users` (
  `userid` int(15) NOT NULL PRIMARY KEY,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

