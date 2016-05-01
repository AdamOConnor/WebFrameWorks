# WebFrameWorksProject

when running this project you must use

- composer update

# About Project

This project was created for the module WebFrameWork development, For third year computer science. The application as follow's is
to demonstrate the use of MVC's using different packagist components using Laragon. Composer is then used to require different packages
so that is in somewhat easier to implement components into the project.

Silex and Twig are required components in the webframeworks assignment.

# Project Group 2 Requirements

=======================================================================
Project Case Study: ITB CDM work placement job application manager
=======================================================================

Overview
--------
Year 3 BA Creative Digital Media students go on a work placement during semester 2 of year 3.

Each student prepares a CV (often tailored for each job application).

The placement lecturer needs a way to give feedback to students about their CVs - sometimes general
feedback to all students, sometimes individual feedback to a student. The feedback (to all or just one) may be an
overall comment about CVs, or about a particular section of the CV.

Employers send details about jobs to the placement lecturer at ITB.

The placement lecturer needs a way to send information to students about a job, and to collect CVs from those
who wish to apply (by a given deadline).

The employer needs a way to receive all the CVs from students who applied before the deadline expired.

Use cases
---------

Use cases: lecturer logs in:
- can see list of students who are not employed, and list of students who are employed
- create new job description (with student application deadline, and employer ID)
- [after application deadline has expired] update which student (if any) was employed
- can view a student's CV
- can post a comment (to all students or just one student) about CVs in general.
- can post a comment (to all students or just one student) about a particular section of a CVs.
- can also CRUD student records

Student
- update CV details (they start with default John Doe content)
- can upload a photo of themselves to go on their CV
- view any CV comments from the lecturer (unread comments are highlighted in some way)
- see a list of jobs currently open for application (and the deadline applications must be submitted by)
- [after application deadline has expired] apply for job


Employer
- after deadline expires can DOWNLOAD all CVs of all students who applied


