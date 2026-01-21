@extends('layouts.layout')

@section('title', 'Switch Company')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Switch Company</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($companies->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">You don't belong to any companies yet.</p>
                    <a href="{{ route('company.signup') }}" class="text-blue-600 hover:underline">
                        Create a new company
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($companies as $company)
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors
                            {{ $currentCompany && $currentCompany->id === $company->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg">{{ $company->name }}</h3>
                                    @if($company->pivot->is_owner)
                                        <span class="text-xs text-gray-500">Owner</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    @if($currentCompany && $currentCompany->id === $company->id)
                                        <span class="text-sm text-blue-600 font-medium">Current</span>
                                    @endif
                                    
                                    <form action="{{ route('companies.switch.store', $company) }}" method="POST" class="inline">
                                        @csrf
                                        @php
                                            $baseDomain = config('tenancy.base_domain', 'app.test');
                                            $protocol = request()->getScheme();
                                            $companyDashboardUrl = sprintf('%s://%s.%s/admin/dashboard', $protocol, $company->slug, $baseDomain);
                                        @endphp
                                        <input type="hidden" name="redirect_to" value="{{ request()->get('redirect_to', $companyDashboardUrl) }}">
                                        <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors
                                            {{ $currentCompany && $currentCompany->id === $company->id ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $currentCompany && $currentCompany->id === $company->id ? 'disabled' : '' }}>
                                            {{ $currentCompany && $currentCompany->id === $company->id ? 'Active' : 'Switch' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($currentCompany)
                    <div class="mt-6 pt-6 border-t">
                        <form action="{{ route('companies.switch.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">
                                Clear company context
                            </button>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
