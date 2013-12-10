// ** I18N

// Calendar EN language
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
// Encoding: any
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Calendar._DN = new Array
("Chủ Nhật",
 "Thứ Hai",
 "Thú Ba",
 "Thứ Tư",
 "Thứ Năm",
 "Thứ Sáu",
 "Thứ Bảy",
 "Chủ Nhật");

// Please note that the following array of short day names (and the same goes
// for short month names, _SMN) isn't absolutely necessary.  We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
//   Calendar._SDN_len = N; // short day name length
//   Calendar._SMN_len = N; // short month name length
//
// If N = 3 then this is not needed either since we assume a value of 3 if not
// present, to be compatible with translation files that were written before
// this feature.

// short day names
Calendar._SDN = new Array
("CN",
 "T2",
 "T3",
 "T4",
 "T5",
 "T6",
 "T7",
 "CN");

// First day of the week. "0" means display Sunday first, "1" means display
// Monday first, etc.
Calendar._FD = 0;

// full month names
Calendar._MN = new Array
("Tháng Giêng",
 "Tháng Hai",
 "Tháng Ba",
 "Tháng Tư",
 "Tháng Năm",
 "Tháng Sáu",
 "Tháng Bảy",
 "Tháng Tám",
 "Tháng Chín",
 "Tháng Mười",
 "Tháng Mười Một",
 "Tháng 12");

// short month names
Calendar._SMN = new Array
("Thg1",
 "Thg2",
 "Thg3",
 "Thg4",
 "Thg5",
 "Thg6",
 "Thg7",
 "Thg8",
 "Thg9",
 "Thg10",
 "Thg11",
 "Thg12");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "Giới thiệu jscalendar";

Calendar._TT["ABOUT"] =
"Trình chọn Ngày/Giờ DHTML\n" +
"(c) dynarch.com 2002-2005 / Tác giả: Mihai Bazon\n" + // don't translate this this ;-)
"Ghé thăm: http://www.dynarch.com/projects/calendar/ để xem phiên bản mới nhất\n" +
"Phân phối dưới GNU LGPL. Xem chi tiết tại http://gnu.org/licenses/lgpl.html." +
"\n\n" +
"Cách chọn ngày:\n" +
"- Sử dụng các nút \xab, \xbb để chọn năm\n" +
"- Sử dụng các nút " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " để chọn tháng\n" +
"- Giữ chuột trên bất ký các nút trên để chọn nhanh hơn.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Cách chọn giờ:\n" +
"- Bấm vào bất kỳ phần thời gian nào để tăng\n" +
"- hoặc giữ phím Shift và bấm để giảm\n" +
"- hoặc bấm và giữ để chọn nhanh hơn.";

Calendar._TT["PREV_YEAR"] = "Năm trước";
Calendar._TT["PREV_MONTH"] = "Tháng trước";
Calendar._TT["GO_TODAY"] = "Tới Hôm nay";
Calendar._TT["NEXT_MONTH"] = "Tháng tiếp theo";
Calendar._TT["NEXT_YEAR"] = "Năm tiếp theo";
Calendar._TT["SEL_DATE"] = "Chọn ngày";
Calendar._TT["DRAG_TO_MOVE"] = "kéo để dịch chuyển";
Calendar._TT["PART_TODAY"] = " (hôm nay)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Calendar._TT["DAY_FIRST"] = "Hiển thị %s trước hết";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "Đóng";
Calendar._TT["TODAY"] = "Hôm nay";
Calendar._TT["TIME_PART"] = "(Giữ Shift)Bấm hoặc kéo để thay đổi giá trị";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "wk";
Calendar._TT["TIME"] = "Thời gian:";
