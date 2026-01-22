@extends('layouts.marketing')

@section('title', 'Security – ' . config('app.name'))

@section('content')
    <div class="bg-white">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-16 lg:py-24">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Security</h1>
                <p class="text-xl text-gray-600 mb-12">We take the security of your payroll data seriously.</p>

                <div class="prose prose-lg max-w-none">
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Encryption</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            All sensitive data, including employee salaries, bank account information, and personal details, are encrypted at rest using industry-standard AES-256 encryption. Data in transit is protected using TLS 1.3 encryption.
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>End-to-end encryption for all financial data</li>
                            <li>Encrypted database backups stored in secure facilities</li>
                            <li>Regular security audits and penetration testing</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Access Controls</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We implement strict access controls to ensure only authorized personnel can access your data:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Multi-factor authentication (MFA) for all user accounts</li>
                            <li>Role-based access control (RBAC) with granular permissions</li>
                            <li>Regular access reviews and audit logs</li>
                            <li>IP whitelisting and geolocation restrictions available</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Infrastructure Security</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Our infrastructure is built on secure, compliant cloud platforms:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Hosted on SOC 2 Type II certified infrastructure</li>
                            <li>Regular security patches and updates</li>
                            <li>DDoS protection and intrusion detection systems</li>
                            <li>24/7 security monitoring and incident response</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Compliance & Certifications</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We maintain compliance with industry standards and regulations:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>GDPR compliant data processing</li>
                            <li>Regular third-party security audits</li>
                            <li>Compliance with local payroll and tax regulations</li>
                            <li>Data residency options available</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Incident Response</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            In the event of a security incident, we have a comprehensive response plan:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                            <li>Immediate containment and investigation</li>
                            <li>Notification to affected customers within 72 hours</li>
                            <li>Post-incident review and improvements</li>
                            <li>Transparent communication throughout the process</li>
                        </ul>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Reporting Security Issues</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            If you discover a security vulnerability, please report it to us immediately:
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Email: <a href="mailto:security@matechpay.com" class="text-indigo-600 hover:text-indigo-700">security@matechpay.com</a>
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            We appreciate responsible disclosure and will work with you to address any security concerns promptly.
                        </p>
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
