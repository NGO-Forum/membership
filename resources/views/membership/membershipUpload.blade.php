<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Application Form</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-600 min-h-screen p-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg p-8 shadow-md">

        <h1 class="text-base md:text-lg text-gray-800 mb-4 leading-relaxed">
            The NGO Forum currently organizes network activities for the following issues. Member organizations are
            received information and are invited to participate in the regular network meetings organized by the NGO
            Forum. Please list the network meetings your NGO intends to regularly attend.
        </h1>

        <p class="text-lg text-gray-700 mb-2">Click on each network to view the ToR:</p>

        <!-- Network Links -->
        <ul class="list-disc ml-6 mb-4 text-blue-600 text-base space-y-1">
            <li><a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_d9b4ed9f583a4b95a3818cc2ab456a94.pdf"
                    target="_blank" class="hover:underline">NECCAW (Environment, Climate Change, Agriculture and
                    Water)</a></li>
            <li><a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_f3786547af4f4bdbabfdc4504eae2b44.pdf"
                    target="_blank" class="hover:underline">BWG (Budget Working Group)</a></li>
            <li><a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_f3786547af4f4bdbabfdc4504eae2b44.pdf"
                    target="_blank" class="hover:underline">RCC (Rivers Coalition of Cambodia)</a></li>
            <li><a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_99b93fa037d5453cb2284d9f32e59659.pdf"
                    target="_blank" class="hover:underline">NRLG (Natural Resources and Land Governance)</a></li>
            <li><a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_7cfd2df44ede463385c212325fed6fd4.pdf"
                    target="_blank" class="hover:underline">GGESI (Gender, Governance, Environment and Social
                    Inclusion)</a></li>
            <li><a href="https://53786707-5124-4ac6-84ff-9389bf387232.usrfiles.com/ugd/537867_68a4cd24ef0b41bbb90a208c73540256.pdf"
                    target="_blank" class="hover:underline">METRI Youth Ambassador Platform for Positive Change</a></li>
        </ul>

        <form action="{{ route('memberships.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Network Participation -->
            <div class="form-section space-y-4 mt-8">
                <h3
                    class="flex items-center gap-2 text-lg text-green-700 font-semibold border-b-2 border-green-700 pb-3 mb-4">
                    <i class="fas fa-network-wired"></i> Network Participation
                </h3>

                <label class="block font-semibold mb-2">Select networks you're interested in:</label>
                <div class="flex flex-col gap-6">
                    @php
                        $networksOld = old('networks', []);
                    @endphp
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="network_neccaw" name="networks[]" value="NECCAW"
                            {{ in_array('NECCAW', $networksOld) ? 'checked' : '' }}
                            class="form-checkbox text-green-600" />
                        <span>NECCAW (Environment, Climate Change, Agriculture and Water)</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="network_bwg" name="networks[]" value="BWG"
                            {{ in_array('BWG', $networksOld) ? 'checked' : '' }} class="form-checkbox text-green-600" />
                        <span>BWG (Budget Working Group)</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="network_rcc" name="networks[]" value="RCC"
                            {{ in_array('RCC', $networksOld) ? 'checked' : '' }} class="form-checkbox text-green-600" />
                        <span>RCC (Rivers Coalition of Cambodia)</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="network_nrlg" name="networks[]" value="NRLG"
                            {{ in_array('NRLG', $networksOld) ? 'checked' : '' }}
                            class="form-checkbox text-green-600" />
                        <span>NRLG (Natural Resources and Land Governance)</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="network_ggesi" name="networks[]" value="GGESI"
                            {{ in_array('GGESI', $networksOld) ? 'checked' : '' }}
                            class="form-checkbox text-green-600" />
                        <span>GGESI (Gender, Governance, Environment and Social Inclusion)</span>
                    </label>
                </div>
            </div>

            <!-- Dynamic Focal Points -->
            <div id="focal-points-section" class="hidden mt-6">
                <h2 class="text-xl font-bold text-green-600 mb-3">Focal Points for Selected Networks</h2>
                <div id="focal-points-container" class="flex flex-col gap-4"></div>
            </div>

            <!-- Required Documents -->
            <h3 class="text-lg font-semibold text-green-700 mt-6 mb-3">
                <i class="fas fa-file-alt text-green-600 mr-2"></i>Required Documents
            </h3>
            @foreach ([
        'letter' => 'Letter explaining why your organization wishes to join NGOF',
        'mission_vision' => "The Organization's Mission and/or Vision Statement (where these exist)",
        'constitution' => "The Organization's Constitution and/or By-Laws (where these exist)",
        'activities' => 'List or summary of current activities in Cambodia; brochures or other explanatory documents',
        'funding' => 'A list of the Organisation’s funding sources, and list of Board Members or other decision-making body',
        'authorization' => 'Official authorization/Registration with MoI to operate in Cambodia',
        'strategic_plan' => 'The organization strategic plan (if available)',
        'fundraising_strategy' => 'The fundraising strategy (Optional)',
        'audit_report' => 'Global audit report / Financial Report',
        'logo' => 'The Logo Organization is required.',
    ] as $field => $label)
                <div class="mb-6 border border-gray-300 rounded-md p-4">
                    <label for="{{ $field }}" class="block font-normal mb-3">{{ $label }}</label>
                    <input type="file" id="{{ $field }}" name="{{ $field }}"
                        class="block w-full text-sm text-gray-500
                               file:mr-4 file:py-2 file:px-4
                               file:rounded file:border-0
                               file:text-sm file:font-semibold
                               file:bg-green-100 file:text-green-700
                               hover:file:bg-green-200">
                    @error($field)
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <!-- Pledge -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-green-600 mb-3">Pledge of commitment:</h2>
                <p class="text-gray-800 mb-4 leading-relaxed">
                    On behalf of my organization, I accept the Mission statement and Values of the NGO Forum on Cambodia
                    and agree to abide by the By-Laws governing membership...
                </p>
                <div class="mb-4">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="pledge_accept" required
                            class="h-4 w-4 text-green-600 border-gray-300 rounded">
                        <span class="text-gray-700 text-base">I accept the pledge of commitment above. (Required)</span>
                    </label>
                </div>

                <!-- Signature -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Signature (Draw below or upload)</label>

                    <canvas id="signature-pad" class="w-full h-64 border rounded-lg bg-gray-50 mb-2"></canvas>

                    <div class="flex space-x-2 mt-2 justify-center">
                        <button type="button" id="clear-signature"
                            class="flex items-center gap-2 px-4 py-2 bg-red-400 text-white rounded hover:bg-red-500">
                            Clear
                        </button>

                        <label
                            class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
                            Upload
                            <input type="file" accept="image/*" id="upload-signature" class="hidden">
                        </label>
                    </div>

                    <input type="hidden" name="signature" id="signature-input">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('membership.form') }}"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Back</a>
                <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Submit</button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const focalPointsSection = document.getElementById("focal-points-section");
            const focalPointsContainer = document.getElementById("focal-points-container");
            const networksCheckboxes = document.querySelectorAll("input[name='networks[]']");

            function updateFocalPoints() {
                focalPointsContainer.innerHTML = '';
                const selectedNetworks = Array.from(networksCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedNetworks.length === 0) {
                    focalPointsSection.classList.add("hidden");
                    return;
                }
                focalPointsSection.classList.remove("hidden");

                selectedNetworks.forEach(network => {
                    const div = document.createElement('div');
                    div.classList.add('focal-point-section', 'border', 'border-gray-300', 'rounded', 'p-5',
                        'mb-6');
                    div.innerHTML = `
                    <h4 class="font-semibold text-lg mb-4">${network} Network</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="focal_name_${network}" class="block font-semibold mb-1">Focal Point Name *</label>
                            <input type="text" id="focal_name_${network}" name="focal_name_${network}" required placeholder="Enter Name"
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
                            <input type="text" id="focal_position_${network}" name="focal_position_${network}" required placeholder="Enter Position"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                        </div>
                        <div>
                            <label for="focal_email_${network}" class="block font-semibold mb-1">Email *</label>
                            <input type="email" id="focal_email_${network}" name="focal_email_${network}" required placeholder="Enter Email"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                        </div>
                        <div>
                            <label for="focal_phone_${network}" class="block font-semibold mb-1">Phone *</label>
                            <input type="tel" id="focal_phone_${network}" name="focal_phone_${network}" required placeholder="Enter Telephone"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                        </div>
                    </div>
                `;
                    focalPointsContainer.appendChild(div);
                });
            }

            // Attach event listeners
            networksCheckboxes.forEach(checkbox =>
                checkbox.addEventListener('change', updateFocalPoints)
            );

            updateFocalPoints(); // Initialize on page load
        });

        // Signature Pad
        const canvas = document.getElementById("signature-pad");
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'white', // ensure solid background
        });

        // Set initial canvas size
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear(); // clear after resize
        }
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        const clearBtn = document.getElementById("clear-signature");
        const uploadInput = document.getElementById("upload-signature");
        const signatureInput = document.getElementById("signature-input");

        // Clear signature
        clearBtn.addEventListener("click", () => {
            signaturePad.clear();
            signatureInput.value = '';
        });

        // Upload signature
        uploadInput.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    signaturePad.clear();
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    signatureInput.value = canvas.toDataURL('image/png');
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        // Always save signature on form submit
        document.querySelector("form").addEventListener("submit", e => {
            if (!signaturePad.isEmpty()) {
                signatureInput.value = signaturePad.toDataURL('image/png');
            }
        });
    </script>

</body>

</html>
