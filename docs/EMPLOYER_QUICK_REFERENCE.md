# Employer System - Quick Reference Guide

## 🎯 Quick Start (5 Minutes)

### For New Employers:
1. **Register** → Select "Employer" role
2. **Complete Profile** → Fill all required fields (aim for 70%+)
3. **Apply for Verification** → Upload business registration
4. **Wait for Approval** → Admin reviews (1-2 business days)
5. **Post Jobs** → Once verified, start posting!

### For Admins:
1. **Review Request** → `/admin/employers/pending`
2. **Check Documents** → View uploaded files
3. **Approve/Reject** → Make decision with notes
4. **Employer Notified** → Automatic email sent

---

## 📊 Dashboard Overview

### Unverified Employer Dashboard:
```
┌─────────────────────────────────────┐
│  Welcome, [Name]!                   │
│  Status: [Pending/Not Applied]      │
├─────────────────────────────────────┤
│  Profile Progress: [__70%___]       │
│                                      │
│  ✓ Complete Profile                 │
│  → Apply for Verification           │
│  ✓ Create Job Drafts (Preview)      │
└─────────────────────────────────────┘
```

### Verified Employer Dashboard:
```
┌──────────────┬──────────────┬──────────────┬──────────────┐
│ Active Jobs  │ Applications │ Response Rate│ Profile      │
│     5        │      23      │     85%      │    100%      │
└──────────────┴──────────────┴──────────────┴──────────────┘

┌─────────────────────────┐ ┌─────────────────────────┐
│ Recent Applications     │ │ Upcoming Deadlines      │
│ • John Doe (Pending)    │ │ • Software Dev (2 days) │
│ • Jane Smith (Short...  │ │ • Marketing Mgr (5 days)│
│ • Mike Jones (Approved) │ │ • HR Assistant (6 days) │
└─────────────────────────┘ └─────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│               [Post Job] [Applications] [Analytics]      │
└─────────────────────────────────────────────────────────┘
```

---

## 🔑 Key Routes

### Employer Routes:
```
GET  /employer/dashboard              # Main dashboard
GET  /employer/profile/edit           # Edit profile
GET  /employer/verification/apply     # Apply for verification
GET  /employer/verification/status    # Check status
```

### Verified Employer Routes:
```
GET  /employer/job-postings           # List jobs
POST /employer/job-postings           # Create job
GET  /employer/applications           # View applications
POST /employer/applications/{id}/shortlist
POST /employer/applications/{id}/schedule-interview
GET  /employer/analytics/overview     # Analytics
```

### Admin Routes:
```
GET  /admin/employers                 # All employers
GET  /admin/employers/pending         # Pending verifications
GET  /admin/employers/{id}/review     # Review verification
POST /admin/employers/{id}/approve
POST /admin/employers/{id}/reject
```

---

## 💡 Common Tasks

### Task 1: Complete Profile
**Location:** `/employer/profile/edit`

**Required Fields:**
- ✓ Company Name
- ✓ Company Size (dropdown)
- ✓ Company Type (dropdown)
- ✓ Website URL
- ✓ Description (100+ chars)
- ✓ Phone
- ✓ Address

**Result:** Profile >= 70% → Can apply for verification

---

### Task 2: Apply for Verification
**Location:** `/employer/verification/apply`

**Requirements:**
- ✓ Profile 70%+ complete
- ✓ Business Registration Certificate (PDF/JPG/PNG, max 5MB)
- ✓ Tax Clearance (optional but recommended)

**Steps:**
1. Upload documents
2. Agree to terms
3. Submit
4. Wait for admin review (1-2 days)

---

### Task 3: Post a Job
**Location:** `/employer/job-postings/create`  
**Required:** Verified employer status

**Fields:**
- Title (e.g., "Software Developer")
- Company Name (auto-filled)
- Description (job details)
- Requirements (qualifications)
- Location
- Employment Type (Full-time, Part-time, Contract)
- Salary Range (optional)
- Application Deadline

**Result:** Job posted immediately, visible to all PWD users

---

### Task 4: Manage Applications
**Location:** `/employer/applications`

**Actions Available:**
1. **View** - See applicant details and PWD profile
2. **Shortlist** - Mark as potential candidate
3. **Schedule Interview** - Set date/time/location
4. **Approve** - Hire the candidate
5. **Reject** - Decline application (optional reason)

**Note:** PWD user receives email notification for each action

---

### Task 5: View Analytics
**Location:** `/employer/analytics/overview`

**Metrics Available:**
- Application trends (30-day chart)
- Job performance (views, applications, conversion)
- Response times
- Comparison with platform average
- Top performing jobs
- Candidate demographics

---

## 🚦 Status Indicators

### Verification Status:
| Badge | Meaning | Next Action |
|-------|---------|-------------|
| 🟡 Not Applied | Profile incomplete or not submitted | Complete profile or apply |
| 🟠 Pending | Under admin review | Wait for decision |
| 🟢 Verified | Approved, can post jobs | Post jobs! |
| 🔴 Rejected | Not approved | Fix issues, resubmit after 7 days |
| ⚠️ Expired | Verification older than 1 year | Renew verification |

### Application Status:
| Badge | Meaning | PWD Notified |
|-------|---------|--------------|
| ⚪ Pending | Just submitted | ❌ No |
| 🔵 Shortlisted | Potential candidate | ✅ Yes |
| 🟡 Interview Scheduled | Interview set | ✅ Yes |
| 🟢 Approved | Hired | ✅ Yes |
| 🔴 Rejected | Not selected | ✅ Yes |

---

## 📧 Email Notifications

### Employers Receive:
1. **Verification Approved**
   - Subject: "Your employer verification has been approved"
   - Action: Login and post jobs

2. **Verification Rejected**
   - Subject: "Your employer verification was not approved"
   - Includes: Rejection reason
   - Action: Fix issues and resubmit

3. **New Application Received**
   - Subject: "New application for [Job Title]"
   - Includes: Applicant name, job title
   - Action: Review application

4. **Verification Expiring Soon**
   - Subject: "Your verification expires in [X] days"
   - Action: Renew verification

### PWD Users Receive:
1. **Application Shortlisted**
   - Subject: "You've been shortlisted for [Job Title]"

2. **Interview Scheduled**
   - Subject: "Interview scheduled for [Job Title]"
   - Includes: Date, time, location

3. **Application Approved**
   - Subject: "Congratulations! You've been hired"

4. **Application Rejected**
   - Subject: "Application update for [Job Title]"
   - Includes: Optional reason

---

## 🔍 Troubleshooting

### Problem: Cannot Apply for Verification
**Solution:** Check profile completion
```php
Profile must be >= 70% complete
Required: company_name, company_size, company_type, website, description, phone, address
```

### Problem: Job Not Visible to PWD Users
**Solution:** Check job status
```
1. Job must be is_active = true
2. Employer must be verified
3. Application deadline must be in future
```

### Problem: Not Receiving Notifications
**Solution:** Check queue worker
```bash
# Start queue worker
php artisan queue:work

# Check email configuration in .env
MAIL_MAILER=smtp
QUEUE_CONNECTION=database
```

### Problem: Documents Not Uploading
**Solution:** Check file permissions and size
```bash
# Check storage permissions
chmod -R 775 storage

# Check max upload size in php.ini
upload_max_filesize = 10M
post_max_size = 10M
```

---

## 🎨 UI Components

### Profile Completion Bar:
```html
<div class="progress">
    <div class="progress-bar bg-success" style="width: 70%">70%</div>
</div>
```

### Status Badge:
```html
<span class="badge bg-success">
    <i class="fas fa-check-circle"></i> Verified
</span>
```

### Application Card:
```html
<div class="card shadow-sm">
    <div class="card-body">
        <h6>John Doe</h6>
        <p class="text-muted">Applied for Software Developer</p>
        <span class="badge bg-warning">Pending</span>
    </div>
</div>
```

---

## 📊 Metrics & KPIs

### Profile Completion Formula:
```
Completion % = (Filled Fields / Total Required Fields) × 100
Required Fields = 9 (name, email, phone, address, company_name, company_size, company_type, website, description)
```

### Response Rate Formula:
```
Response Rate = (Applications Responded To / Total Applications) × 100
Responded = status IN ('shortlisted', 'approved', 'rejected')
```

### Conversion Rate Formula:
```
Conversion Rate = (Approved Applications / Total Applications) × 100
```

---

## 🔐 Permissions Matrix

| Action | Unverified | Pending | Verified | Admin |
|--------|-----------|---------|----------|-------|
| View Dashboard | ✅ | ✅ | ✅ | ✅ |
| Edit Profile | ✅ | ✅ | ✅ | ✅ (all) |
| Apply Verification | ✅* | ❌ | ❌ | N/A |
| View Status | ✅ | ✅ | ✅ | ✅ |
| Create Job Draft | ✅ | ✅ | ✅ | N/A |
| Post Job | ❌ | ❌ | ✅ | N/A |
| View Applications | ❌ | ❌ | ✅ | ✅ (all) |
| Manage Applications | ❌ | ❌ | ✅ | ✅ (all) |
| View Analytics | ❌ | ❌ | ✅ | ✅ (all) |
| Approve Verification | ❌ | ❌ | ❌ | ✅ |

*Only if profile >= 70%

---

## 🌐 API Endpoints (if enabled)

```http
GET /api/employer/stats
Response: {
    "active_jobs": 5,
    "total_applications": 23,
    "response_rate": 85.5
}

GET /api/employer/applications?status=pending
Response: [
    {
        "id": 1,
        "user": {...},
        "job": {...},
        "status": "pending",
        "created_at": "2024-12-01T10:00:00Z"
    }
]

POST /api/employer/applications/{id}/status
Body: { "status": "shortlisted" }
Response: { "success": true, "notification_sent": true }
```

---

## 📱 Mobile Responsive

All employer pages are mobile-responsive:
- ✅ Dashboard cards stack on mobile
- ✅ Forms use mobile-friendly inputs
- ✅ Tables scroll horizontally
- ✅ Touch-friendly buttons (min 44px)
- ✅ Swipe gestures for lists

---

## 🎯 Best Practices

### For Employers:
1. **Complete profile fully** (aim for 100%)
2. **Upload clear documents** (high-quality scans)
3. **Respond to applications quickly** (within 48 hours)
4. **Provide detailed job descriptions**
5. **Be clear about PWD accommodations**

### For Admins:
1. **Review verifications within 24-48 hours**
2. **Provide clear rejection reasons**
3. **Check business registration authenticity**
4. **Monitor job postings for quality**
5. **Respond to employer inquiries promptly**

---

## 📞 Support Contacts

- **Email:** support@pwdjobportal.com
- **Phone:** +1 (234) 567-890
- **Hours:** Monday-Friday, 9 AM - 5 PM

---

**Quick Links:**
- [Full Documentation](./EMPLOYER_SYSTEM_GUIDE.md)
- [Summary](./EMPLOYER_SYSTEM_SUMMARY.md)
- [API Reference](#)
- [Video Tutorial](#)

---

**Last Updated:** 2024-12-02  
**Version:** 1.0
