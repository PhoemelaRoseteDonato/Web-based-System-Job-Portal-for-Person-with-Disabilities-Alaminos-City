# Employer Account System - Complete Guide

## Overview
The PWD Job Portal includes a comprehensive employer account system with verification workflow, profile management, and job posting capabilities. This document outlines the complete system architecture and user flow.

## System Architecture

### 1. **Account Registration & Setup**
When an employer registers:
- Account created with role='employer'
- Status: Unverified (employer_verification_status='unverified' or NULL)
- Access: Limited dashboard, profile management only
- Cannot post jobs until verified

### 2. **Profile Completion Workflow**

#### Required Fields (70% minimum for verification):
- **Basic Information:**
  - Full Name
  - Email Address
  - Phone Number
  - Physical Address

- **Company Information:**
  - Company Name
  - Company Size (1-10, 11-50, 51-200, 201-500, 501-1000, 1000+)
  - Company Type (private, public, government, nonprofit, educational)
  - Company Website (URL)
  - Company Description (100-2000 characters)

#### Optional Enhancements:
- Company Logo
- Resume/Company Profile Document
- Additional Documentation

### 3. **Verification Application Process**

#### Step 1: Profile Completion Check
- System checks if profile completion >= 70%
- If incomplete, redirect to profile edit page
- Display progress bar and missing fields

#### Step 2: Document Submission
Employers must submit:
- **Required:**
  - Business Registration Certificate (PDF, JPG, PNG, max 5MB)
  
- **Recommended:**
  - Tax Clearance Certificate (PDF, JPG, PNG, max 5MB)
  
- **Optional:**
  - Additional supporting documents

#### Step 3: Admin Review
- Documents stored in `storage/app/private/employer-verification/{user_id}/`
- Admin receives notification (queue system)
- Review interface shows all documents and company information
- Admin actions:
  1. **Approve** - Sets verification status to 'verified', expiry date to +1 year
  2. **Reject** - Sets status to 'rejected', includes reason, allows resubmit after 7 days
  3. **Request More Info** - Keeps status 'pending', requests additional information

#### Step 4: Notification
- Email sent to employer (queued)
- In-app notification
- Dashboard alert

### 4. **Verification Status States**

| Status | Description | Access Level |
|--------|-------------|--------------|
| **Not Applied** | Profile incomplete or not submitted | Dashboard, Profile Edit only |
| **Pending** | Submitted, awaiting admin review | Dashboard, Profile Edit, View Status |
| **Verified** | Approved by admin | Full access: Post Jobs, View Applications, Analytics |
| **Rejected** | Not approved (with reason) | Dashboard, Profile Edit, Can resubmit after 7 days |
| **Expired** | Verification older than 1 year | Dashboard, Renew Verification |

### 5. **Job Posting Workflow (Verified Employers Only)**

#### Job Creation:
```php
Route: /employer/job-postings/create
Access: Requires verified.employer middleware
```

1. **Employer creates job posting**
   - All job fields (title, description, requirements, etc.)
   - Employment type, location, salary range
   - Application deadline
   - Status initially set to 'active'

2. **Job appears in employer dashboard**
   - Employer can see job in "My Jobs"
   - Can edit, duplicate, or deactivate
   - Can view applications received

3. **Job is visible to PWD users**
   - Listed in public job postings
   - PWD users can view and apply
   - Application tracked with timestamps

4. **Admin oversight**
   - Admin can view all job postings
   - Can deactivate inappropriate jobs
   - Can contact employer for clarifications
   - **Note:** Jobs are posted directly but admin has monitoring capability

### 6. **Employer Dashboard Features**

#### For Unverified Employers:
- Welcome message with setup guide
- Profile completion progress (percentage)
- Verification status card
- Quick actions:
  - Complete Profile
  - View Requirements
  - Create Job Draft (preview only)
- Missing fields checklist
- Help & support resources

#### For Verified Employers:
- **Statistics Cards:**
  - Active Jobs Count
  - Total Applications Received
  - Response Rate (%)
  - Profile Completion (%)

- **Recent Applications:**
  - Last 5 applications with status
  - Quick links to application details
  - Filter by status (pending, approved, rejected)

- **Upcoming Deadlines:**
  - Jobs with deadlines in next 7 days
  - Application count per job
  - View count per job
  - Quick extend deadline action

- **Quick Actions:**
  - Post New Job
  - View All Applications
  - Analytics Dashboard
  - Update Profile

- **Performance Metrics:**
  - Average time to first application
  - Application-to-hire conversion rate
  - Job completion rate
  - Average response time to applications

### 7. **Application Management**

#### Viewing Applications:
```php
Route: /employer/applications
Access: Verified employers only
```

Features:
- List all applications for employer's jobs
- Filter by status, job posting, date range
- Sort by date, status, applicant name
- Search by applicant name or job title

#### Application Actions:
1. **View Details**
   - Applicant profile
   - PWD profile information
   - Resume download
   - Application date and status history

2. **Status Updates:**
   - Shortlist (sends notification to applicant)
   - Schedule Interview (includes interview details)
   - Approve (hire candidate)
   - Reject (with optional reason)

3. **Bulk Actions:**
   - Bulk status updates
   - Bulk export to Excel/CSV

### 8. **Analytics & Reports**

#### Available to Verified Employers:
```php
Routes:
/employer/analytics/overview
/employer/analytics/performance
/employer/analytics/applications-trend
/employer/analytics/jobs-performance
```

#### Metrics Tracked:
1. **Application Trends:**
   - Daily/weekly/monthly application volumes
   - Application sources
   - Peak application times

2. **Job Performance:**
   - Views per job
   - Applications per job
   - Application-to-view ratio
   - Top performing jobs
   - Underperforming jobs

3. **Employer Performance:**
   - Average response time
   - Response rate
   - Conversion rate (applications to hires)
   - Time to fill positions
   - Candidate satisfaction (if implemented)

4. **Platform Comparison:**
   - Employer metrics vs. platform average
   - Industry benchmarks
   - Improvement suggestions

### 9. **Database Schema**

#### Users Table (Employer Columns):
```sql
employer_verification_status VARCHAR(20) -- 'pending', 'verified', 'rejected'
employer_verified_at TIMESTAMP
verification_submitted_at TIMESTAMP
verification_expires_at TIMESTAMP
verification_rejected_reason TEXT
can_resubmit_verification_at TIMESTAMP
verification_documents JSON -- {'business_registration': 'path', 'tax_clearance': 'path'}
verification_notes TEXT -- Admin notes
company_name VARCHAR(255)
company_size VARCHAR(50)
company_type VARCHAR(50)
website VARCHAR(255)
description TEXT
```

#### Job Postings Table:
```sql
id BIGINT PRIMARY KEY
created_by BIGINT -- Foreign key to users.id
title VARCHAR(255)
company VARCHAR(255)
description TEXT
requirements TEXT
location VARCHAR(255)
employment_type VARCHAR(50)
salary_range VARCHAR(100)
application_deadline DATE
is_active BOOLEAN
is_featured BOOLEAN
views INT
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### Job Applications Table:
```sql
id BIGINT PRIMARY KEY
job_posting_id BIGINT
user_id BIGINT -- PWD user who applied
status VARCHAR(20) -- 'pending', 'shortlisted', 'approved', 'rejected'
status_updated_at TIMESTAMP
interview_date TIMESTAMP
interview_location VARCHAR(255)
notes TEXT
created_at TIMESTAMP
updated_at TIMESTAMP
```

### 10. **Middleware Protection**

#### EmployerMiddleware:
- Checks if user role === 'employer'
- Redirects non-employers to home

#### PendingEmployerVerification:
- Allows access to basic features
- Suggests verification if profile complete
- Redirects to renewal if expired

#### VerifiedEmployer:
- Blocks access if not verified
- Shows verification requirements
- Blocks if verification expired
- Allows renewal process

### 11. **Notification System**

#### Employer Notifications:
1. **Verification Approved:**
   - Email + In-app notification
   - Welcome message with next steps
   - Link to post first job

2. **Verification Rejected:**
   - Email with rejection reason
   - Link to resubmit application
   - Requirements checklist

3. **New Application Received:**
   - Real-time notification
   - Application details summary
   - Link to review application

4. **Verification Expiring Soon:**
   - 30 days before expiration
   - 7 days before expiration
   - Link to renewal process

5. **Application Status Changed:**
   - When PWD user updates application
   - When admin intervenes

### 12. **Admin Panel Features**

#### Employer Management:
```php
Routes: /admin/employers/*
Access: Admin only
```

Features:
- List all employers (filter by verification status)
- View pending verification requests
- Review employer documents
- Approve/Reject verification
- View employer job postings
- Deactivate employer accounts
- View employer statistics
- Handle verification renewals
- Contact employers

#### Verification Review Interface:
- Company information display
- Document viewer (inline PDF/image)
- Verification history
- Admin notes section
- Quick action buttons (Approve/Reject/Keep Pending)
- Reason input for rejection

### 13. **Key Features Summary**

#### Profile Completion System:
✅ Progress tracking (percentage)
✅ Missing fields identification
✅ Auto-save drafts
✅ Validation on submission

#### Verification System:
✅ Document upload with validation
✅ Secure storage (private disk)
✅ Admin review interface
✅ Email notifications (queued)
✅ Status tracking
✅ Resubmission after rejection
✅ Annual renewal process
✅ Expiration alerts

#### Job Posting System:
✅ Create/Edit/Delete jobs
✅ Draft jobs (for unverified)
✅ Active/Inactive toggle
✅ Deadline management
✅ View tracking
✅ Featured jobs option
✅ Duplicate job functionality

#### Application System:
✅ View all applications
✅ Filter and sort
✅ Status management
✅ Interview scheduling
✅ Bulk actions
✅ Export functionality
✅ Automatic notifications

#### Analytics System:
✅ Real-time metrics
✅ Historical trends
✅ Comparison with averages
✅ Performance insights
✅ Exportable reports

### 14. **API Endpoints** (if needed)

```php
GET /api/employer/stats
GET /api/employer/applications
GET /api/employer/jobs
GET /api/employer/analytics/trends
POST /api/employer/application/{id}/status
```

### 15. **Security Measures**

1. **Access Control:**
   - Role-based middleware
   - Verification status checks
   - Owner verification for resources

2. **Data Protection:**
   - Documents in private storage
   - Encrypted sensitive data
   - Secure file upload validation

3. **Rate Limiting:**
   - API endpoint limits
   - Document upload limits
   - Email notification throttling

4. **Audit Trail:**
   - Admin actions logged
   - Status changes tracked
   - Timestamps on all updates

### 16. **User Experience Flow**

```
Registration → Profile Setup (70%+) → Apply Verification → Wait for Admin Review
                ↓                              ↓
         Create Drafts                 Receive Notification
                                               ↓
                                    [APPROVED] → Post Jobs → Manage Applications
                                    [REJECTED] → Fix Issues → Resubmit
```

### 17. **File Locations**

#### Controllers:
- `app/Http/Controllers/EmployerController.php`
- `app/Http/Controllers/EmployerDashboardController.php`
- `app/Http/Controllers/EmployerVerificationController.php`

#### Models:
- `app/Models/User.php` (employer methods)
- `app/Models/JobPosting.php`
- `app/Models/JobApplication.php`

#### Views:
- `resources/views/employer/dashboard.blade.php`
- `resources/views/employer/welcome.blade.php`
- `resources/views/employer/profile/edit.blade.php`
- `resources/views/employer/verification/apply.blade.php`
- `resources/views/employer/verification/status.blade.php`
- `resources/views/employer/job-postings/*`
- `resources/views/employer/applications/*`

#### Middleware:
- `app/Http/Middleware/EmployerMiddleware.php`
- `app/Http/Middleware/VerifiedEmployer.php`
- `app/Http/Middleware/PendingEmployerVerification.php`

#### Notifications:
- `app/Notifications/EmployerVerificationApproved.php`
- `app/Notifications/EmployerVerificationRejected.php`
- `app/Notifications/EmployerVerificationKept.php`
- `app/Notifications/NewApplicationAdminNotification.php`

### 18. **Testing Checklist**

- [ ] Register new employer account
- [ ] Attempt to post job (should be blocked)
- [ ] Complete profile to 70%+
- [ ] Submit verification application
- [ ] Admin approves verification
- [ ] Receive approval email
- [ ] Post first job
- [ ] Receive application notification
- [ ] Manage application status
- [ ] View analytics
- [ ] Test verification expiration
- [ ] Test renewal process

### 19. **Future Enhancements**

1. **Payment Integration:**
   - Featured job postings
   - Premium employer accounts
   - Job boost options

2. **Advanced Matching:**
   - AI-powered candidate matching
   - Skill-based recommendations
   - Automated screening

3. **Communication:**
   - In-app messaging
   - Interview scheduling integration
   - Video interview platform

4. **Reporting:**
   - Custom report builder
   - Scheduled reports
   - API access for third-party tools

---

## Quick Reference Commands

### Create Employer Account:
```bash
# Via Registration Form
Route: /register (select "Employer" role)
```

### Verify Employer (Admin):
```bash
# Via Admin Panel
Route: /admin/employers/{id}/review
```

### Check Verification Status:
```php
$user->isEmployerVerified() // true/false
$user->getEmployerVerificationStatus() // string
```

### Post Job (Verified Only):
```bash
Route: /employer/job-postings/create
```

---

**Last Updated:** {{ date('Y-m-d') }}
**System Version:** 1.0
**Documentation Version:** 1.0
