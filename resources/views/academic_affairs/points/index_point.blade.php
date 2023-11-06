@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-responsive table-bordered">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sinh viên</th>
                    <th>Mã sinh viên</th>
                    <th>Lý thuyết</th>
                    <th>Thực hành</th>
                    <th>ASM</th>
                    <th>Kết quả</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($points as $point)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $point->name }}</td>
                        <td>{{ $point->student_code }}</td>
                        <td contenteditable="true" class="editable" data-field="theory">{{ $point->theory }}</td>
                        <td contenteditable="true" class="editable" data-field="practice">{{ $point->practice }}</td>
                        <td contenteditable="true" class="editable" data-field="asm">{{ $point->asm }}</td>
                        <td>{{ $point->result }}</td>
                        <td>
{{--                            <form action="{{ route('aa-point-edit') }}" method="GET">--}}
{{--                                @csrf--}}
{{--                                <input name="point_id" hidden value="{{ $point->point_id }}">--}}
{{--                                <button class="btn btn-warning">Nhập điểm</button>--}}
{{--                            </form>--}}
                            <button onclick="saveData(this)" data-point-id="{{ $point->point_id }}">Lưu</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{--    <script>--}}
{{--        function saveData() {--}}
{{--            var theory = document.getElementById('theory').innerText;--}}
{{--            var practice = document.getElementById('practice').innerText;--}}
{{--            var asm = document.getElementById('asm').innerText;--}}
{{--            fetch('/save-data', {--}}
{{--                method: 'POST',--}}
{{--                headers: {--}}
{{--                    'Content-Type': 'application/json',--}}
{{--                    'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
{{--                },--}}
{{--                body: JSON.stringify({--}}
{{--                    theory: theory,--}}
{{--                    practice: practice,--}}
{{--                    asm: asm--}}
{{--                })--}}
{{--            })--}}
{{--                .then(response => response.json())--}}
{{--                .then(data => {--}}
{{--                    if (data.success) {--}}
{{--                        alert('Lưu thành công');--}}
{{--                    } else {--}}
{{--                        alert('Lưu thất bại');--}}
{{--                    }--}}
{{--                })--}}
{{--                .catch(error => {--}}
{{--                    console.error('Lỗi:', error);--}}
{{--                });--}}
{{--        }--}}
{{--    </script>--}}


{{--    <script>--}}
{{--        function saveData() {--}}
{{--            var theoryValue = document.getElementById('theory').innerText;--}}
{{--            var practiceValue = document.getElementById('practice').innerText;--}}
{{--            var asmValue = document.getElementById('asm').innerText;--}}

{{--            // Gửi các giá trị đến server bằng AJAX request--}}
{{--            var xhr = new XMLHttpRequest();--}}
{{--            xhr.open('POST', '/save-data', true);--}}
{{--            xhr.setRequestHeader('Content-Type', 'application/json');--}}
{{--            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');--}}
{{--            xhr.onreadystatechange = function () {--}}
{{--                if (xhr.readyState === 4 && xhr.status === 200) {--}}
{{--                    // Xử lý phản hồi từ server (nếu cần)--}}
{{--                }--}}
{{--            };--}}
{{--            var data = JSON.stringify({--}}
{{--                theory: theoryValue,--}}
{{--                practice: practiceValue,--}}
{{--                asm: asmValue--}}
{{--            });--}}
{{--            xhr.send(data);--}}
{{--        }--}}
{{--    </script>--}}


    <script>
        function saveData(button) {
            var row = button.closest('tr');
            var pointId = button.getAttribute('data-point-id');
            var fields = row.querySelectorAll('.editable');
            var data = {
                pointId: pointId,
            };

            fields.forEach(function (field) {
                var fieldName = field.getAttribute('data-field');
                var fieldValue = field.innerText.trim();
                data[fieldName] = fieldValue;
            });

            // Gửi dữ liệu đến phía server
            fetch('/save-point-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(function (response) {
                    // Xử lý phản hồi từ server (nếu cần)
                })
                .catch(function (error) {
                    // Xử lý lỗi (nếu có)
                });
        }
    </script>
@endsection
