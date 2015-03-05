# SilverStripe Image improvements

## Work in progress

This module is still work in progress.
This module exists because of missing features in SilverStripe and might 
change its API or be completely obsolete once Image is re-factored.

## Current Features

- SetCroppedSize - more consistent name, allows to specify crop origin
- SetMaxRatioSize - only SetRatioSize if image to large
- SetQuality - set jpeg quality
- SetGreyscale - greyscale image
- GetAsDataURI - returns the image as base64 data URI string

## Installation

#### Requirements

- php GD (ImagickBackend not implemented yet)

#### Installing the module

1. Install the module using composer or download and place in your project folder
2. Run `?flush=1`

## Usage

    $Image.SetCroppedSize(300, 300, 'left', 'top') <!-- image is cropped to 300x300 from the left top -->
    $Image.SetMaxRatioSize(1000, 1000) <!-- returns an image of 1000x1000 or smaller -->
    $Image.SetQuality(75) <!-- only for jpeg, returns an image with quality set to 75 -->
    $Image.SetGreyscale <!-- returns a grey scale version of the image -->
    <img alt="" src="$Image.GetAsDataURI" />

    <!-- as with all SilverStripe image methods, they can be chained: -->
    $Image.SetMaxRatioSize(1000, 1000).SetQuality(75)
	<img alt="" src="$Image.SetCroppedSize(300, 300).SetQuality(50).getURL" />    
	<img alt="" src="$Image.SetCroppedSize(300, 300).SetQuality(50).GetAsDataURI" />    
	<% with $Image.SetMaxRatioSize(1000, 1000) %>
		<div style="background-image: url('$SetQuality(75).SetGreyscale(50, 50, 50).getURL');
					width: {$getWidth}px; 
					height: {$getHeight}px;">
		</div>
	<% end_with %>

## License

	Copyright (c) 2015, Zauberfisch
	All rights reserved.

	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:
		* Redistributions of source code must retain the above copyright
		  notice, this list of conditions and the following disclaimer.
		* Redistributions in binary form must reproduce the above copyright
		  notice, this list of conditions and the following disclaimer in the
		  documentation and/or other materials provided with the distribution.
		* Neither the name Zauberfisch nor the names of other contributors may 
		  be used to endorse or promote products derived from this software 
		  without specific prior written permission.

	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
	ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
	DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
