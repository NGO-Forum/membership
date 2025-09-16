<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NGOF Membership Reconfirmation</title>
  <link rel="icon" href="/logo.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-600 font-sans min-h-screen">
  <div class="container max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <header class="mb-8 text-center px-4 sm:px-0">
      <div class="flex flex-col items-center sm:flex-row sm:justify-center gap-3 mb-3 text-green-700">
        <i class="fas fa-handshake text-yellow-400 text-4xl sm:text-3xl"></i>
        <h1 class="text-2xl sm:text-3xl font-bold">NGOF Membership Reconfirmation</h1>
      </div>
      <p class="text-gray-600 font-light max-w-md mx-auto px-2 sm:px-0">
        Update your organization's membership information
      </p>
    </header>


    <div>
      @if ($errors->any())
        <div class="mb-6 text-red-600">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mb-6 space-y-2 text-gray-700">
        <p class="text-green-700 text-lg">Dear NGOF Member,</p>
        <p>To reconfirm your organization's membership and update our records, please complete this form. Your information will be kept confidential and used only for NGOF purposes. Thank you for your cooperation!</p>
      </div>

      <form id="membershipForm" method="POST" action="{{ route('membership.reconfirm.submit') }}" autocomplete="on" class="space-y-10">
        @csrf
        <input type="hidden" name="save_and_next" id="save_and_next" value="0" />

        <div class="form-section">
          <h3 class="flex items-center gap-2 text-lg text-green-700 font-semibold border-b-2 border-green-700 pb-3 mb-4">
            <i class="fas fa-check-circle"></i> Membership Status
          </h3>
          <p class="text-gray-700 mb-3">Do you confirm your organization's continued membership in NGOF? *</p>
          <div class="flex gap-8">
            <label class="inline-flex items-center gap-2 cursor-pointer">
              <input type="radio" id="membership_yes" name="membership" value="Yes" {{ old('membership') == 'Yes' ? 'checked' : '' }} required
                class="form-radio text-green-600" />
              <span>Yes</span>
            </label>
            <label class="inline-flex items-center gap-2 cursor-pointer">
              <input type="radio" id="membership_no" name="membership" value="No" {{ old('membership') == 'No' ? 'checked' : '' }} required
                class="form-radio text-green-600" />
              <span>No</span>
            </label>
          </div>
        </div>

        <div id="mainFormFields" style="{{ old('membership') === 'No' ? 'display:none;' : '' }}">
          <!-- Basic NGO Information -->
          <div class="form-section space-y-6">
            <h3 class="flex items-center gap-2 text-lg text-green-700 font-semibold border-b-2 border-green-700 pb-3 mb-4">
              <i class="fas fa-user"></i> Basic NGO Information
            </h3>

            <div class="space-y-4">
              <div>
                <label for="ngo_name" class="block font-semibold mb-2">Name of NGO *</label>
                <input type="text" id="ngo_name" name="ngo_name" required placeholder="Enter your organization name" autocomplete="organization"
                  value="{{ old('ngo_name') }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="director_name" class="block font-semibold mb-2">Name of Director *</label>
                <input type="text" id="director_name" name="director_name" required placeholder="Enter director's name" autocomplete="name"
                  value="{{ old('director_name') }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="director_phone" class="block font-semibold mb-2">Phone Number of Director *</label>
                <input type="tel" id="director_phone" name="director_phone" required placeholder="Enter director's phone number" autocomplete="tel"
                  value="{{ old('director_phone') }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="director_email" class="block font-semibold mb-2">E-mail address of Director *</label>
                <input type="email" id="director_email" name="director_email" required placeholder="Enter director's email" autocomplete="email"
                  value="{{ old('director_email') }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="alt_name" class="block font-semibold mb-2">Name of Alternative (Representative) (If any)</label>
                <input type="text" id="alt_name" name="alt_name" placeholder="Enter alternative's name" autocomplete="name"
                  value="{{ old('alt_name') }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="alt_phone" class="block font-semibold mb-2">Phone Number of the Alternative (if any)</label>
                <input type="tel" id="alt_phone" name="alt_phone" placeholder="Enter alternative's phone number" autocomplete="tel"
                  value="{{ old('alt_phone') }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="alt_email" class="block font-semibold mb-1">E-mail address of the Alternative (if any)</label>
                <input type="email" id="alt_email" name="alt_email" placeholder="Enter alternative's email" autocomplete="email"
                  value="{{ old('alt_email') }}"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
            </div>
          </div>

          <!-- Network Participation -->
          <div class="form-section space-y-4 mt-8">
            <h3 class="flex items-center gap-2 text-lg text-green-700 font-semibold border-b-2 border-green-700 pb-3 mb-4">
              <i class="fas fa-network-wired"></i> Network Participation
            </h3>

            <label class="block font-semibold mb-2">Select networks you're interested in:</label>
            <div class="flex flex-col gap-6">
              @php
                $networksOld = old('networks', []);
              @endphp
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="network_neccaw" name="networks[]" value="NECCAW" {{ in_array('NECCAW', $networksOld) ? 'checked' : '' }}
                  class="form-checkbox text-green-600" />
                <span>NECCAW (Environment, Climate Change, Agriculture and Water)</span>
              </label>
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="network_bwg" name="networks[]" value="BWG" {{ in_array('BWG', $networksOld) ? 'checked' : '' }}
                  class="form-checkbox text-green-600" />
                <span>BWG (Budget Working Group)</span>
              </label>
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="network_rcc" name="networks[]" value="RCC" {{ in_array('RCC', $networksOld) ? 'checked' : '' }}
                  class="form-checkbox text-green-600" />
                <span>RCC (Rivers Coalition of Cambodia)</span>
              </label>
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="network_nrlg" name="networks[]" value="NRLG" {{ in_array('NRLG', $networksOld) ? 'checked' : '' }}
                  class="form-checkbox text-green-600" />
                <span>NRLG (Natural Resources and Land Governance)</span>
              </label>
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="network_ggesi" name="networks[]" value="GGESI" {{ in_array('GGESI', $networksOld) ? 'checked' : '' }}
                  class="form-checkbox text-green-600" />
                <span>GGESI (Gender, Governance, Environment and Social Inclusion)</span>
              </label>
            </div>
          </div>

          <!-- Focal Points -->
          <div id="focalPointsSection" class="form-section mt-8" style="{{ count($networksOld) ? '' : 'display:none;' }}">
            <h3 class="flex items-center gap-2 text-lg text-green-700 font-semibold border-b-2 border-green-700 pb-3 mb-4">
              <i class="fas fa-users"></i> Focal Point Details
            </h3>
            <div id="focalPointsContainer" class="space-y-6">
              @foreach ($networksOld as $network)
                <div class="focal-point-section border border-gray-300 rounded p-5">
                  <h4 class="font-semibold text-lg mb-4">{{ $network }} Network</h4>
                  <div class="space-y-4">
                    <div>
                      <label for="focal_name_{{ $network }}" class="block font-semibold mb-1">Focal Point Name *</label>
                      <input type="text" id="focal_name_{{ $network }}" name="focal_name_{{ $network }}" required placeholder="Enter name" autocomplete="name"
                        value="{{ old("focal_name_{$network}") }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>
                    <div>
                      <label for="focal_sex_{{ $network }}" class="block font-semibold mb-1">Sex *</label>
                      <select id="focal_sex_{{ $network }}" name="focal_sex_{{ $network }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select sex</option>
                        <option value="Male" {{ old("focal_sex_{$network}") == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old("focal_sex_{$network}") == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old("focal_sex_{$network}") == 'Other' ? 'selected' : '' }}>Other</option>
                      </select>
                    </div>
                    <div>
                      <label for="focal_position_{{ $network }}" class="block font-semibold mb-1">Position *</label>
                      <input type="text" id="focal_position_{{ $network }}" name="focal_position_{{ $network }}" required placeholder="Enter position" autocomplete="organization-title"
                        value="{{ old("focal_position_{$network}") }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>
                    <div>
                      <label for="focal_email_{{ $network }}" class="block font-semibold mb-1">Email *</label>
                      <input type="email" id="focal_email_{{ $network }}" name="focal_email_{{ $network }}" required placeholder="Enter email" autocomplete="email"
                        value="{{ old("focal_email_{$network}") }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>
                    <div>
                      <label for="focal_phone_{{ $network }}" class="block font-semibold mb-1">Phone *</label>
                      <input type="tel" id="focal_phone_{{ $network }}" name="focal_phone_{{ $network }}" required placeholder="Enter phone" autocomplete="tel"
                        value="{{ old("focal_phone_{$network}") }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="form-section">
            <h3 class="flex items-center gap-2 text-lg text-green-700 font-semibold border-b-2 border-green-700 pb-3 mt-6 mb-4">
              <i class="fas fa-info-circle"></i> Additional Information
            </h3>
            <label class="block font-semibold mb-2">Will you agree to provide further information later if requested? *</label>
            <div class="flex gap-8">
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="radio" id="more_info_yes" name="more_info" value="Yes" {{ old('more_info') == 'Yes' ? 'checked' : '' }} required
                  class="form-radio text-green-600" />
                <span>Yes</span>
              </label>
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="radio" id="more_info_no" name="more_info" value="No" {{ old('more_info') == 'No' ? 'checked' : '' }} required
                  class="form-radio text-green-600" />
                <span>No</span>
              </label>
            </div>
          </div>

          <div class="flex justify-end mt-10 gap-4">
            <button type="submit" id="submitBtn" class="bg-green-700 hover:bg-green-800 text-white rounded-md px-8 py-3 font-semibold flex items-center gap-2">
              <span>Submit</span>
              <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const membershipRadios = document.querySelectorAll('input[name="membership"]');
      const mainFields = document.getElementById('mainFormFields');
      const networksCheckboxes = document.querySelectorAll('input[name="networks[]"]');
      const focalPointsSection = document.getElementById('focalPointsSection');
      const focalPointsContainer = document.getElementById('focalPointsContainer');

      function toggleMainFields() {
        const selected = document.querySelector('input[name="membership"]:checked');
        if (selected && selected.value === 'Yes') {
          mainFields.style.display = '';
        } else if (selected && selected.value === 'No') {
          mainFields.style.display = 'none';
          // Submit the form immediately when "No" is selected
          document.getElementById('membershipForm').submit();
        } else {
          mainFields.style.display = 'none';
        }
      }

      function updateFocalPoints() {
        focalPointsContainer.innerHTML = '';
        const selectedNetworks = Array.from(networksCheckboxes).filter(cb => cb.checked).map(cb => cb.value);

        if (selectedNetworks.length === 0) {
          focalPointsSection.style.display = 'none';
          return;
        }
        focalPointsSection.style.display = '';

        selectedNetworks.forEach(network => {
          const div = document.createElement('div');
          div.classList.add('focal-point-section', 'border', 'border-gray-300', 'rounded', 'p-5', 'mb-6');
          div.innerHTML = `
            <h4 class="font-semibold text-lg mb-4">${network} Network</h4>
            <div class="space-y-4">
              <div>
                <label for="focal_name_${network}" class="block font-semibold mb-1">Focal Point Name *</label>
                <input type="text" id="focal_name_${network}" name="focal_name_${network}" required autocomplete="name"  placeholder="Enter Name"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="focal_sex_${network}" class="block font-semibold mb-1">Sex *</label>
                <select id="focal_sex_${network}" name="focal_sex_${network}" required
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                  <option value="">Select sex</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div>
                <label for="focal_position_${network}" class="block font-semibold mb-1">Position *</label>
                <input type="text" id="focal_position_${network}" name="focal_position_${network}" required autocomplete="organization-title"  placeholder="Enter Position"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="focal_email_${network}" class="block font-semibold mb-1">Email *</label>
                <input type="email" id="focal_email_${network}" name="focal_email_${network}" required autocomplete="email" placeholder="Enter Email"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
              <div>
                <label for="focal_phone_${network}" class="block font-semibold mb-1">Phone *</label>
                <input type="tel" id="focal_phone_${network}" name="focal_phone_${network}" required autocomplete="tel" placeholder="Enter Telephone"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
              </div>
            </div>
          `;
          focalPointsContainer.appendChild(div);
        });
      }

      membershipRadios.forEach(radio => radio.addEventListener('change', toggleMainFields));
      networksCheckboxes.forEach(checkbox => checkbox.addEventListener('change', updateFocalPoints));

      toggleMainFields();
      updateFocalPoints();
    });

    document.addEventListener('DOMContentLoaded', () => {
      const membershipRadios = document.querySelectorAll('input[name="membership"]');
      const mainFields = document.getElementById('mainFormFields');
      const yesMoreInfo = document.getElementById('more_info_yes');
      const noMoreInfo = document.getElementById('more_info_no');
      const submitBtn = document.getElementById('submitBtn');

      function toggleMainFields() {
          const selected = document.querySelector('input[name="membership"]:checked');
          if (!selected) return;

          if (selected.value === 'Yes') {
              mainFields.style.display = '';
          } else {
              mainFields.style.display = 'none';
              // auto-submit when "No"
              document.getElementById('membershipForm').submit();
          }
      }

      function toggleSubmit() {
          if (yesMoreInfo.checked || noMoreInfo.checked) {
              submitBtn.style.display = 'inline-flex';
          } else {
              submitBtn.style.display = 'none';
          }
      }

      membershipRadios.forEach(radio => radio.addEventListener('change', toggleMainFields));
      yesMoreInfo.addEventListener('change', toggleSubmit);
      noMoreInfo.addEventListener('change', toggleSubmit);

      // initialize
      toggleMainFields();
      toggleSubmit();
    });
  </script>
</body>
</html>
