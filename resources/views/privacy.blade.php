@extends('layouts.marketing')

@section('title', 'Privacy Policy – ' . config('app.name'))

@section('content')
    <div class="bg-white">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-16 lg:py-24">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
                <p class="text-xl text-gray-600 mb-12">Your privacy is important to us. This policy explains how we collect, use, and protect your information.</p>

                <div class="prose prose-lg max-w-none">
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Information We Collect</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We collect information necessary to provide our payroll services:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li><strong>Company Information:</strong> Business name, address, tax identification numbers, and banking details</li>
                            <li><strong>Employee Data:</strong> Names, addresses, social security numbers, salary information, and employment details</li>
                            <li><strong>Account Information:</strong> Email addresses, usernames, and authentication credentials</li>
                            <li><strong>Usage Data:</strong> Log files, IP addresses, browser information, and system activity</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">How We Use Your Information</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We use collected information to:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Process payroll and calculate taxes</li>
                            <li>Generate payslips and tax documents</li>
                            <li>Comply with legal and regulatory requirements</li>
                            <li>Provide customer support and improve our services</li>
                            <li>Send important service updates and notifications</li>
                            <li>Prevent fraud and ensure security</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Sharing and Disclosure</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We do not sell your personal information. We may share data only in these circumstances:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li><strong>Service Providers:</strong> With trusted third-party vendors who assist in providing our services (under strict confidentiality agreements)</li>
                            <li><strong>Legal Requirements:</strong> When required by law, court order, or government regulation</li>
                            <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets (with prior notice)</li>
                            <li><strong>With Your Consent:</strong> When you explicitly authorize us to share information</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Retention</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We retain your data for as long as necessary to provide our services and comply with legal obligations:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Active account data: Retained while your account is active</li>
                            <li>Payroll records: Retained for 7 years as required by tax regulations</li>
                            <li>Deleted accounts: Data is securely deleted within 30 days of account closure, except where legal retention is required</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Rights</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Depending on your location, you may have the following rights:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li><strong>Access:</strong> Request a copy of your personal data</li>
                            <li><strong>Correction:</strong> Request correction of inaccurate data</li>
                            <li><strong>Deletion:</strong> Request deletion of your data (subject to legal requirements)</li>
                            <li><strong>Portability:</strong> Request transfer of your data to another service</li>
                            <li><strong>Objection:</strong> Object to certain processing activities</li>
                            <li><strong>Restriction:</strong> Request restriction of data processing</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed">
                            To exercise these rights, please contact us at <a href="mailto:privacy@matechpay.com" class="text-indigo-600 hover:text-indigo-700">privacy@matechpay.com</a>
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Cookies and Tracking</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We use cookies and similar technologies to:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Maintain your session and authentication</li>
                            <li>Remember your preferences and settings</li>
                            <li>Analyze usage patterns to improve our services</li>
                            <li>Provide security features</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed">
                            You can control cookies through your browser settings, though this may affect functionality.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">International Data Transfers</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Your data may be transferred to and processed in countries other than your own. We ensure appropriate safeguards are in place, including:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Standard contractual clauses approved by data protection authorities</li>
                            <li>Adequacy decisions where applicable</li>
                            <li>Other legally recognized transfer mechanisms</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Children's Privacy</h2>
                        <p class="text-gray-700 leading-relaxed">
                            Our services are not intended for individuals under 18 years of age. We do not knowingly collect personal information from children.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to This Policy</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We may update this privacy policy from time to time. We will notify you of significant changes by:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Email notification to registered users</li>
                            <li>Prominent notice on our website</li>
                            <li>In-app notifications for active users</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Us</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            If you have questions about this privacy policy or our data practices, please contact us:
                        </p>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-700 mb-2"><strong>Email:</strong> <a href="mailto:privacy@matechpay.com" class="text-indigo-600 hover:text-indigo-700">privacy@matechpay.com</a></p>
                            <p class="text-gray-700"><strong>Data Protection Officer:</strong> Available upon request</p>
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
