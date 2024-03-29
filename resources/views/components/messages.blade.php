@if(session()->has('message'))
<div id="alert-div" class="bg-green-200 fixed bottom-0 right-0 z-20 m-2 border-t-4 border-green-900 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
    <div class="flex">
      <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-900 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
      <div>
        <p class="font-bold">Notification</p>
        <p class="text-sm">{{session('message')}}</p>
      </div>
    </div>
  </div>

@endif
{{-- x-data="{show : true}" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:leave="transition ease-in duration-500" --}}
<script>
    // Function to remove the alert after 5 seconds
    function removeAlert() {
      const alertDiv = document.getElementById("alert-div");
      if (alertDiv) {
        alertDiv.remove();
      }
    }
  
    // Set a timeout to call the function after 5 seconds (5000 milliseconds)
    setTimeout(removeAlert, 5000);
    
  </script>