@extends('layouts.marketing')

@section('title', 'Terms of Service – ' . config('app.name'))

@section('content')
    <div class="bg-white">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-16 lg:py-24">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Terms of Service</h1>
                <p class="text-xl text-gray-600 mb-12">Please read these terms carefully before using our services.</p>

                <div class="prose prose-lg max-w-none">
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Acceptance of Terms</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            By accessing or using {{ config('app.name', 'MatechPay') }} ("the Service"), you agree to be bound by these Terms of Service ("Terms"). If you disagree with any part of these terms, you may not access the Service.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            These Terms apply to all users of the Service, including companies, administrators, and employees.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Description of Service</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            {{ config('app.name', 'MatechPay') }} is a cloud-based payroll management system that provides:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Payroll calculation and processing</li>
                            <li>Tax calculation and compliance</li>
                            <li>Payslip generation and distribution</li>
                            <li>Employee data management</li>
                            <li>Reporting and analytics</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed">
                            We reserve the right to modify, suspend, or discontinue any part of the Service at any time with reasonable notice.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Account Registration</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            To use the Service, you must:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Provide accurate, current, and complete information during registration</li>
                            <li>Maintain and update your account information</li>
                            <li>Maintain the security of your account credentials</li>
                            <li>Accept responsibility for all activities under your account</li>
                            <li>Be at least 18 years old and have authority to bind your organization</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Subscription and Payment</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            <strong>Subscription Plans:</strong> The Service is offered on a subscription basis. Pricing and features are detailed on our pricing page.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            <strong>Billing:</strong> Subscriptions are billed in advance on a monthly or annual basis. All fees are non-refundable except as required by law.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            <strong>Free Trial:</strong> We may offer a free trial period. At the end of the trial, you will be charged unless you cancel before the trial expires.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            <strong>Price Changes:</strong> We reserve the right to modify pricing with 30 days' notice. Price changes will not affect your current billing cycle.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            <strong>Cancellation:</strong> You may cancel your subscription at any time. Cancellation takes effect at the end of your current billing period.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">5. User Responsibilities</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            You agree to:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Use the Service only for lawful purposes and in compliance with applicable laws</li>
                            <li>Provide accurate and complete information</li>
                            <li>Maintain the confidentiality of your account credentials</li>
                            <li>Notify us immediately of any unauthorized access</li>
                            <li>Not attempt to gain unauthorized access to the Service</li>
                            <li>Not interfere with or disrupt the Service or servers</li>
                            <li>Not use the Service to transmit malicious code or spam</li>
                            <li>Comply with all applicable payroll, tax, and employment laws</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Data and Content</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            <strong>Your Data:</strong> You retain all rights to data you upload or enter into the Service. You grant us a license to use, store, and process this data to provide the Service.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            <strong>Data Accuracy:</strong> You are solely responsible for the accuracy and completeness of data entered into the Service. We are not liable for errors resulting from inaccurate input.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            <strong>Data Backup:</strong> While we maintain backups, you are responsible for maintaining your own backups of critical data.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Intellectual Property</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            The Service, including its design, features, and functionality, is owned by {{ config('app.name', 'MatechPay') }} and protected by copyright, trademark, and other intellectual property laws.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            You may not copy, modify, distribute, sell, or lease any part of the Service without our written permission.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Service Availability</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We strive to maintain high availability but do not guarantee uninterrupted or error-free service. The Service may be unavailable due to:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Scheduled maintenance (with advance notice when possible)</li>
                            <li>Unforeseen technical issues</li>
                            <li>Force majeure events</li>
                            <li>Third-party service disruptions</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Limitation of Liability</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            TO THE MAXIMUM EXTENT PERMITTED BY LAW:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>The Service is provided "as is" without warranties of any kind</li>
                            <li>We are not liable for indirect, incidental, or consequential damages</li>
                            <li>Our total liability is limited to the amount you paid in the 12 months preceding the claim</li>
                            <li>We are not responsible for payroll errors resulting from incorrect input or misuse</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed">
                            Some jurisdictions do not allow the exclusion of certain warranties or limitations of liability, so some of the above may not apply to you.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Indemnification</h2>
                        <p class="text-gray-700 leading-relaxed">
                            You agree to indemnify and hold harmless {{ config('app.name', 'MatechPay') }}, its officers, directors, employees, and agents from any claims, damages, losses, or expenses (including legal fees) arising from your use of the Service, violation of these Terms, or infringement of any rights of another.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Termination</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We may suspend or terminate your account if you:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Violate these Terms</li>
                            <li>Fail to pay subscription fees</li>
                            <li>Engage in fraudulent or illegal activity</li>
                            <li>Misuse the Service</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed">
                            Upon termination, your access to the Service will cease, and we may delete your data after a reasonable retention period as required by law.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Changes to Terms</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We reserve the right to modify these Terms at any time. We will notify you of material changes by:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Email to your registered address</li>
                            <li>Notice on our website</li>
                            <li>In-app notification</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed">
                            Continued use of the Service after changes constitutes acceptance of the modified Terms.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">13. Governing Law</h2>
                        <p class="text-gray-700 leading-relaxed">
                            These Terms are governed by and construed in accordance with the laws of [Your Jurisdiction], without regard to conflict of law principles. Any disputes will be resolved in the courts of [Your Jurisdiction].
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">14. Contact Information</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            If you have questions about these Terms, please contact us:
                        </p>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-700 mb-2"><strong>Email:</strong> <a href="mailto:legal@matechpay.com" class="text-indigo-600 hover:text-indigo-700">legal@matechpay.com</a></p>
                            <p class="text-gray-700"><strong>Support:</strong> <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-700">Contact Us</a></p>
                        </div>
                    </section>

                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            Last updated: {{ date('F j, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
