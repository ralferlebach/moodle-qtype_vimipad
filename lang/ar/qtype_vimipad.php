<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Arabic language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'أشكال العُقَد المسموح بها';
$string['allowedshapes_help'] = 'قائمة اختيارية مفصولة بفواصل لأشكال العُقَد التي يمكن للمتعلم استخدامها. اتركها فارغة للسماح بجميع الأشكال التي يسمح بها ملف تعريف المخطط المختار.';
$string['answer'] = 'خريطتك';
$string['grading'] = 'تقدير تلقائي';
$string['invalidmap'] = 'الخريطة المُرسَلة ليست خريطة ViMi Pad صالحة لهذا السؤال.';
$string['mapsettings'] = 'إعدادات الخريطة';
$string['minnodes'] = 'الحد الأدنى لعدد العُقَد';
$string['minnodes_help'] = 'يُستخدَم فقط عند عدم تعيين خريطة مرجعية. يحصل المتعلم على نصف الدرجة عندما تحتوي خريطته على هذا العدد من العُقَد على الأقل. الصفر يعني أن هذا النصف يُمنَح دائماً.';
$string['minrelations'] = 'الحد الأدنى لعدد العلاقات';
$string['minrelations_help'] = 'يُستخدَم فقط عند عدم تعيين خريطة مرجعية. يحصل المتعلم على نصف الدرجة عندما تحتوي خريطته على هذا العدد من العلاقات على الأقل. الصفر يعني أن هذا النصف يُمنَح دائماً.';
$string['noscript'] = 'يتطلب هذا السؤال تفعيل جافاسكربت لإنشاء الخريطة.';
$string['pleasedrawmap'] = 'يرجى إنشاء خريطتك قبل الإرسال.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'يطلب سؤال ViMi Pad من المتعلم إنشاء خريطة معرفية مرئية (خريطة مفاهيمية أو خريطة ذهنية أو شجرة وغيرها) مقيَّدة بملف تعريف مخطط مختار. تُقدَّر الخريطة المُرسَلة تلقائياً مقابل الخريطة المرجعية للمؤلف، أو مقابل متطلبات هيكلية دنيا عند عدم تعيين مرجع.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'إضافة سؤال ViMi Pad';
$string['pluginnameediting'] = 'تحرير سؤال ViMi Pad';
$string['pluginnamesummary'] = 'يتيح للمتعلمين إنشاء خريطة معرفية مرئية كإجابة، مقيَّدة بملف تعريف مخطط ومُقدَّرة تلقائياً. مدعوم بنشاط ViMi Pad ‏(mod_vimipad).';
$string['privacy:metadata'] = 'لا يخزّن نوع سؤال ViMi Pad أي بيانات شخصية خاصة به. تُخزَّن خريطة المتعلم بواسطة محرك الأسئلة في Moodle كاستجابة المحاولة.';
$string['profile'] = 'ملف تعريف المخطط';
$string['profile_help'] = 'ملف تعريف مخطط ViMi Pad الذي تُقيَّد به خريطة المتعلم، مثل الخريطة المفاهيمية أو الخريطة الذهنية أو الشجرة. تُوفَّر القائمة من نشاط ViMi Pad.';
$string['referencemap'] = 'الخريطة المرجعية';
$string['referencemap_help'] = 'ارفع حل المؤلف كخريطة ViMi Pad مُصدَّرة إلى JSON. عند تعيينها، تُقدَّر خريطة المتعلم بحسب عدد ما تُعيد إنتاجه من عُقَد وعلاقات المرجع. اتركها فارغة لتقدير الخريطة بدلاً من ذلك وفق الحد الأدنى لعدد العُقَد والعلاقات.';
$string['referencemapincompatible'] = 'الخريطة المرجعية لا تطابق الملف التعريفي المختار والأشكال المسموح بها. ارفع خريطة مرجعية مطابقة أو أعِد الملف التعريفي كما كان.';
$string['referencemapinvalid'] = 'الملف المرفوع ليس JSON صالحاً. يرجى رفع خريطة ViMi Pad مُصدَّرة كملف JSON.';
$string['responsesummary'] = 'خريطة تحتوي على {$a->nodes} عقدة و {$a->relations} علاقة';
$string['shape:ellipse'] = 'شكل بيضاوي';
$string['shape:rect'] = 'مستطيل';
$string['shape:roundrect'] = 'مستطيل بزوايا دائرية';
$string['shapesnotinprofile'] = 'شكل واحد أو أكثر من الأشكال المختارة غير مدعوم في ملف تعريف المخطط المختار.';
