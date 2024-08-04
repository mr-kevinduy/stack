# Project Management

https://blog.neoscorp.vn/cac-tai-lieu-thiet-ke-phan-mem/
https://www.bellevuecollege.edu/wp-content/uploads/sites/135/2019/04/SDD_RoadTrip.pdf
https://qiita.com/chocode/items/fd51dd8f561e2a0fbd70
https://github.com/laravel-modules-com/breeze-demo
https://github.com/nafiesl/free-pmo/tree/master
https://github.com/donnemartin/system-design-primer

- Introduction
    - Definitions (What?)
    - Purpose (Why?)
    - Scope
    - References
- System Overview
- System Structure Diagram
    - System Concept Diagram
    - System workflow
    - Usecase Diagram
- Funtion Requirement
    - List of system features
    - Features details
- Input/Output Data Requirements
    - Input data list
    - Input data details (field, type,...)
    - Output data list
    - Output data details (field, type,...)

- Non-functional requirements
    - Security requirements
    - Quality and performance requirements

- Other
    - Brief schedule (schedule sơ lươc)
    - Sơ đồ Stakeholder (relationship diagram)

1. External design (ED) / Basic Design :
Thực hiện sau khi hầu như những yêu cầu của khách hàng được đáp ứng - Thiết kế bên ngoài là việc thiết kế chi tiết cấu trúc hệ thống dựa vào tài liệu định nghĩa yêu cầu. Basic Design được xây dựng dựa trên quan điểm của lập trình viên. Tuy nhiên, khách hàng có thể sẽ tham gia việc review tài liệu này. => Là thiết kế hệ thống hướng về phía người dùng
    - Architectural Design (Thiết kế phương pháp / Thiết kế kiến trúc):
        + What'll you using? - Sử dụng cái gì?
            - cấu hình phần cứng, phần mềm, ...
            - Chỉ định ngôn ngữ, nền tảng flatform để phát triển.
        + What process will you using? - Quy trình gì sẽ áp dụng?
            - Resource (Thể chế nhân sự)
            - Development Schedule (Lịch trình phát triển)
            - Project Management Tool (Công cụ quản lý dự án)
        + How is the system? - Hệ thống như thế nào?
            - System structure diagram (Sơ đồ cấu trúc hệ thống)
    - Feature Design (Thiết kế tính năng)
        + Sơ đồ di chuyển màn hình
        + Sơ đồ thiết kế layout màn hình (UI)
        + Scenario (kịch bản)
        + Bussiness/Logic
        + Bảng danh sách các tính năng (function)
        + Thiết kế database: Sơ đồ ER, định nghĩa Table
    - Other
        + Thiết kế bảo mật
        + Thiết kế vận hành
        + Thiết kế kiểm
        + ...

=> Basic Design Document:
    Tổng quan hệ thống
        Scenario
        Bussiness/Logic
    Cấu trúc hệ thống
        Sơ đồ cấu trúc hệ thống
        Luồng nghiệp vụ/Sơ đồ hoạt động
        Sơ đồ cấu hình phần cứng/phần mềm
        Sơ đồ cấu hình network
    Bảng danh sách tính năng
    Đặc tả database
        Sơ đồ ER
        Tài liệu định nghĩa table
    Thiết kế UI
        Sơ đồ di chuyển màn hình
        Sơ đồ thiết kế layout màn hình
    Other
        Thể chế/resource phát triển
        Schedule phát triển
        Công cụ quản lý dự án

2. Internal design (ID) / Detailed design :
    - Thuyết minh, phân chia chức năng - Class diagram
    - Data flow - DFD (Data flow diagram)
    - Modules details
        Module name
        Vai trò
        Parameter, respone
        Sơ lược xử lý
        Note


